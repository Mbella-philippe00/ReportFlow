import { create } from 'zustand';

type UiState = {
    commandPaletteOpen: boolean;
    desktopSidebarCollapsed: boolean;
    mobileSidebarOpen: boolean;
    setCommandPaletteOpen: (open: boolean) => void;
    setDesktopSidebarCollapsed: (collapsed: boolean) => void;
    setMobileSidebarOpen: (open: boolean) => void;
    toggleCommandPalette: () => void;
    toggleDesktopSidebar: () => void;
    toggleMobileSidebar: () => void;
};

export const useUiStore = create<UiState>((set) => ({
    commandPaletteOpen: false,
    desktopSidebarCollapsed: false,
    mobileSidebarOpen: false,
    setCommandPaletteOpen: (open) => set({ commandPaletteOpen: open }),
    setDesktopSidebarCollapsed: (collapsed) => set({ desktopSidebarCollapsed: collapsed }),
    setMobileSidebarOpen: (open) => set({ mobileSidebarOpen: open }),
    toggleCommandPalette: () => set((state) => ({ commandPaletteOpen: !state.commandPaletteOpen })),
    toggleDesktopSidebar: () => set((state) => ({ desktopSidebarCollapsed: !state.desktopSidebarCollapsed })),
    toggleMobileSidebar: () => set((state) => ({ mobileSidebarOpen: !state.mobileSidebarOpen })),
}));

