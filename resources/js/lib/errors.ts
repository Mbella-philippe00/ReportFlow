import { HttpError } from '@/lib/http';

export const isAbortError = (error: unknown): boolean =>
    error instanceof DOMException && error.name === 'AbortError';

export const getErrorMessage = (error: unknown, fallback = 'Something went wrong. Please try again.'): string => {
    if (isAbortError(error)) {
        return 'The request was cancelled.';
    }

    if (error instanceof HttpError) {
        return error.message || fallback;
    }

    if (error instanceof Error && error.message.trim().length > 0) {
        return error.message;
    }

    return fallback;
};

export const getValidationSummary = (error: unknown, fallback = 'Please review the highlighted fields.'): string => {
    if (error instanceof HttpError && error.validationErrors) {
        const firstError = Object.values(error.validationErrors).flat()[0];

        return firstError ?? fallback;
    }

    return getErrorMessage(error, fallback);
};

export const isRetryableError = (error: unknown): boolean => {
    if (isAbortError(error)) {
        return false;
    }

    if (!(error instanceof HttpError)) {
        return true;
    }

    return error.status === 408 || error.status === 429 || error.status >= 500;
};

export const getAiErrorHint = (error: unknown): string => {
    const message = getErrorMessage(error).toLowerCase();

    if (message.includes('quota')) {
        return 'The provider quota may be exhausted. ReportFlow will use the configured backend fallback when available.';
    }

    if (message.includes('api key') || message.includes('key missing') || message.includes('invalid')) {
        return 'Ask an administrator to verify the configured AI provider keys.';
    }

    if (message.includes('provider')) {
        return 'Retry the request or switch the active provider from the backend configuration.';
    }

    return 'Retry the request. If it continues, check provider configuration and network availability.';
};
