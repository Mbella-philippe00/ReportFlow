const readEnv = (key: string, fallback: string): string => {
    const value = import.meta.env[key];

    return typeof value === 'string' && value.trim().length > 0 ? value : fallback;
};

const normalizeRouterBasename = (basename: string): string => {
    const trimmedBasename = basename.trim();

    if (trimmedBasename === '' || trimmedBasename === '/') {
        return '/';
    }

    return `/${trimmedBasename.replace(/^\/+|\/+$/g, '')}`;
};

export const env = Object.freeze({
    apiBaseUrl: readEnv('VITE_API_BASE_URL', '/api'),
    appName: readEnv('VITE_APP_NAME', 'ReportFlow'),
    environment: import.meta.env.MODE,
    isDevelopment: import.meta.env.DEV,
    isProduction: import.meta.env.PROD,
    routerBasename: normalizeRouterBasename(readEnv('VITE_ROUTER_BASENAME', '/')),
});

