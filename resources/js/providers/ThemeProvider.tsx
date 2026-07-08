import { useEffect } from 'react';
import type { PropsWithChildren } from 'react';

import { applyTheme, persistThemeMode, subscribeToSystemTheme } from '@/lib/theme';
import { useThemeStore } from '@/stores/theme.store';

export function ThemeProvider({ children }: PropsWithChildren) {
    const mode = useThemeStore((state) => state.mode);

    useEffect(() => {
        persistThemeMode(mode);

        if (mode !== 'system') {
            applyTheme(mode);
            return undefined;
        }

        return subscribeToSystemTheme(applyTheme);
    }, [mode]);

    return <>{children}</>;
}

