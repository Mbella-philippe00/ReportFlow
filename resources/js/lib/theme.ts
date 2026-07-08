import { isThemeMode, themeConfig } from '@/config/theme';
import type { ResolvedTheme, ThemeMode } from '@/types';

const systemThemeQuery = '(prefers-color-scheme: dark)';

export const resolveSystemTheme = (): ResolvedTheme => {
    if (typeof window === 'undefined') {
        return 'light';
    }

    return window.matchMedia(systemThemeQuery).matches ? 'dark' : 'light';
};

export const applyTheme = (theme: ResolvedTheme): void => {
    if (typeof document === 'undefined') {
        return;
    }

    document.documentElement.classList.toggle('dark', theme === 'dark');
    document.documentElement.dataset.theme = theme;
    document.documentElement.style.colorScheme = theme;
};

export const getInitialThemeMode = (): ThemeMode => {
    if (typeof window === 'undefined') {
        return themeConfig.defaultMode;
    }

    const storedMode = window.localStorage.getItem(themeConfig.storageKey);

    return isThemeMode(storedMode) ? storedMode : themeConfig.defaultMode;
};

export const persistThemeMode = (mode: ThemeMode): void => {
    if (typeof window === 'undefined') {
        return;
    }

    window.localStorage.setItem(themeConfig.storageKey, mode);
};

export const subscribeToSystemTheme = (onChange: (theme: ResolvedTheme) => void): (() => void) => {
    if (typeof window === 'undefined') {
        return () => undefined;
    }

    const mediaQuery = window.matchMedia(systemThemeQuery);
    const syncSystemTheme = () => onChange(resolveSystemTheme());

    syncSystemTheme();
    mediaQuery.addEventListener('change', syncSystemTheme);

    return () => mediaQuery.removeEventListener('change', syncSystemTheme);
};

