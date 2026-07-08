import { env } from '@/config/env';
import { useAuthStore } from '@/stores/auth.store';
import type { ApiErrorResponse, ValidationErrors } from '@/types';

export type HttpMethod = 'DELETE' | 'GET' | 'PATCH' | 'POST' | 'PUT';

export type HttpRequestOptions = Omit<RequestInit, 'body' | 'headers' | 'method'> & {
    authenticated?: boolean;
    body?: unknown;
    headers?: HeadersInit;
    method?: HttpMethod;
};

export class HttpError extends Error {
    readonly payload: unknown;
    readonly status: number;
    readonly validationErrors?: ValidationErrors;

    constructor(status: number, payload: unknown) {
        const message = extractErrorMessage(payload) ?? `Request failed with status ${status}.`;

        super(message);
        this.name = 'HttpError';
        this.payload = payload;
        this.status = status;
        this.validationErrors = extractValidationErrors(payload);
    }
}

type RequestSignal = {
    cleanup: () => void;
    signal: AbortSignal;
};

const absoluteUrlPattern = /^https?:\/\//i;

const buildUrl = (path: string): string => {
    if (absoluteUrlPattern.test(path)) {
        return path;
    }

    const baseUrl = env.apiBaseUrl.replace(/\/$/, '');
    const normalizedPath = path.startsWith('/') ? path : `/${path}`;

    return `${baseUrl}${normalizedPath}`;
};

const createRequestSignal = (externalSignal?: AbortSignal | null): RequestSignal => {
    const controller = new AbortController();

    if (!externalSignal) {
        return {
            cleanup: () => undefined,
            signal: controller.signal,
        };
    }

    const abortRequest = () => controller.abort(externalSignal.reason);

    if (externalSignal.aborted) {
        abortRequest();
    } else {
        externalSignal.addEventListener('abort', abortRequest, { once: true });
    }

    return {
        cleanup: () => externalSignal.removeEventListener('abort', abortRequest),
        signal: controller.signal,
    };
};

const extractErrorMessage = (payload: unknown): string | undefined => {
    if (isApiErrorResponse(payload) && typeof payload.message === 'string') {
        return payload.message;
    }

    return undefined;
};

const extractValidationErrors = (payload: unknown): ValidationErrors | undefined => {
    if (isApiErrorResponse(payload) && payload.errors) {
        return payload.errors;
    }

    return undefined;
};

const isApiErrorResponse = (payload: unknown): payload is ApiErrorResponse =>
    typeof payload === 'object' && payload !== null;

const parseResponse = async (response: Response): Promise<unknown> => {
    if (response.status === 204) {
        return undefined;
    }

    const contentType = response.headers.get('content-type') ?? '';

    if (contentType.includes('application/json')) {
        return response.json();
    }

    return response.text();
};

const serializeBody = (body: unknown, headers: Headers): BodyInit | undefined => {
    if (body === undefined || body === null) {
        return undefined;
    }

    if (body instanceof FormData) {
        return body;
    }

    if (body instanceof Blob || body instanceof URLSearchParams || typeof body === 'string') {
        return body;
    }

    if (!headers.has('Content-Type')) {
        headers.set('Content-Type', 'application/json');
    }

    return JSON.stringify(body);
};

const handleUnauthorizedResponse = (authenticated: boolean) => {
    if (!authenticated) {
        return;
    }

    useAuthStore.getState().clearSession();

    if (typeof window !== 'undefined' && window.location.pathname !== '/login') {
        window.dispatchEvent(new CustomEvent('reportflow:auth-expired'));
        window.location.assign('/login');
    }
};

export const http = async <TResponse>(path: string, options: HttpRequestOptions = {}): Promise<TResponse> => {
    const { authenticated = true, body, headers: customHeaders, method = 'GET', ...requestOptions } = options;
    const headers = new Headers(customHeaders);
    const requestSignal = createRequestSignal(requestOptions.signal);

    if (!headers.has('Accept')) {
        headers.set('Accept', 'application/json');
    }

    const token = useAuthStore.getState().token;

    if (authenticated && token) {
        headers.set('Authorization', `Bearer ${token}`);
    }

    try {
        const response = await fetch(buildUrl(path), {
            ...requestOptions,
            body: serializeBody(body, headers),
            credentials: requestOptions.credentials ?? 'same-origin',
            headers,
            method,
            signal: requestSignal.signal,
        });
        const payload = await parseResponse(response);

        if (!response.ok) {
            if (response.status === 401) {
                handleUnauthorizedResponse(authenticated);
            }

            throw new HttpError(response.status, payload);
        }

        return payload as TResponse;
    } finally {
        requestSignal.cleanup();
    }
};
