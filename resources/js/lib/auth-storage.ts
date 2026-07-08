import type { AuthUser } from '@/types';

export type AuthStorageSnapshot = {
    token: string | null;
    user: AuthUser | null;
};

export type AuthStorageStrategy = {
    clear: () => void;
    read: () => AuthStorageSnapshot;
    write: (snapshot: AuthStorageSnapshot) => void;
};

const storageKey = 'reportflow.auth.v1';

const emptySnapshot = (): AuthStorageSnapshot => ({
    token: null,
    user: null,
});

const isBrowserStorageAvailable = () => {
    try {
        return typeof window !== 'undefined' && typeof window.localStorage !== 'undefined';
    } catch {
        return false;
    }
};

const isRecord = (value: unknown): value is Record<string, unknown> => typeof value === 'object' && value !== null;

const isAuthUser = (value: unknown): value is AuthUser => {
    if (!isRecord(value)) {
        return false;
    }

    return (
        typeof value.id === 'number' &&
        typeof value.name === 'string' &&
        typeof value.email === 'string' &&
        Array.isArray(value.roles) &&
        value.roles.every((role) => role === 'employee' || role === 'manager' || role === 'super-admin')
    );
};

const parseSnapshot = (value: string | null): AuthStorageSnapshot => {
    if (!value) {
        return emptySnapshot();
    }

    try {
        const parsed = JSON.parse(value) as unknown;

        if (!isRecord(parsed) || typeof parsed.token !== 'string' || !isAuthUser(parsed.user)) {
            return emptySnapshot();
        }

        return {
            token: parsed.token,
            user: parsed.user,
        };
    } catch {
        return emptySnapshot();
    }
};

const createLocalStorageAuthStorage = (): AuthStorageStrategy => ({
    clear: () => {
        if (isBrowserStorageAvailable()) {
            window.localStorage.removeItem(storageKey);
        }
    },
    read: () => {
        if (!isBrowserStorageAvailable()) {
            return emptySnapshot();
        }

        return parseSnapshot(window.localStorage.getItem(storageKey));
    },
    write: (snapshot) => {
        if (!isBrowserStorageAvailable()) {
            return;
        }

        if (!snapshot.token || !snapshot.user) {
            window.localStorage.removeItem(storageKey);
            return;
        }

        window.localStorage.setItem(storageKey, JSON.stringify(snapshot));
    },
});

export const authStorage = createLocalStorageAuthStorage();
export const authStorageKey = storageKey;
