import { env } from '@/config/env';

export const appConfig = Object.freeze({
    apiBaseUrl: env.apiBaseUrl,
    description: 'Enterprise weekly reporting workflow platform',
    manifestPath: '/manifest.webmanifest',
    name: env.appName,
    rootElementId: 'app',
    routerBasename: env.routerBasename,
    themeColor: '#2563eb',
});

