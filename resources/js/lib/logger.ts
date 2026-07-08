import { env } from '@/config/env';

type LogContext = Record<string, unknown>;

type LogLevel = 'debug' | 'error' | 'info' | 'warn';

const writeLog = (level: LogLevel, message: string, context?: LogContext): void => {
    if (level === 'debug' && !env.isDevelopment) {
        return;
    }

    const payload = context ?? {};

    if (level === 'error') {
        console.error(message, payload);
        return;
    }

    if (level === 'warn') {
        console.warn(message, payload);
        return;
    }

    if (level === 'info') {
        console.info(message, payload);
        return;
    }

    console.debug(message, payload);
};

export const logger = Object.freeze({
    debug: (message: string, context?: LogContext) => writeLog('debug', message, context),
    error: (message: string, context?: LogContext) => writeLog('error', message, context),
    info: (message: string, context?: LogContext) => writeLog('info', message, context),
    warn: (message: string, context?: LogContext) => writeLog('warn', message, context),
});
