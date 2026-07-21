export const featureFlags = Object.freeze({
    ai: true,
    analytics: false,
    dashboard: true,
    employees: false,
    notifications: false,
    profile: false,
    pwa: false,
    reports: true,
    settings: false,
    workflow: true,
});

export type FeatureKey = keyof typeof featureFlags;

export const isFeatureEnabled = (feature: FeatureKey): boolean => featureFlags[feature];
