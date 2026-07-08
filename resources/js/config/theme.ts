import type { ThemeMode } from '@/types';

export const themeModes = ['light', 'dark', 'system'] as const satisfies readonly ThemeMode[];

export const themeConfig = Object.freeze({
    defaultMode: 'system' as ThemeMode,
    storageKey: 'reportflow.theme',
});

export const isThemeMode = (value: unknown): value is ThemeMode =>
    typeof value === 'string' && themeModes.includes(value as ThemeMode);
