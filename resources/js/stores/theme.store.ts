import { create } from 'zustand';

import { getInitialThemeMode } from '@/lib/theme';
import type { ThemeMode } from '@/types';

type ThemeState = {
    mode: ThemeMode;
    setMode: (mode: ThemeMode) => void;
};

export const useThemeStore = create<ThemeState>((set) => ({
    mode: getInitialThemeMode(),
    setMode: (mode) => set({ mode }),
}));

