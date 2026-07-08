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

const emptySnapshot = (): AuthStorageSnapshot => ({
    token: null,
    user: null,
});

const createMemoryAuthStorage = (): AuthStorageStrategy => {
    let currentSnapshot = emptySnapshot();

    return {
        clear: () => {
            currentSnapshot = emptySnapshot();
        },
        read: () => ({ ...currentSnapshot }),
        write: (snapshot) => {
            currentSnapshot = { ...snapshot };
        },
    };
};

export const authStorage = createMemoryAuthStorage();

