export type NotificationRealtimeTransport = 'echo' | 'polling' | 'push' | 'sse' | 'websocket';

export type NotificationRealtimeEvent = {
    id?: string;
    queryKey?: readonly unknown[];
    reason: 'created' | 'deleted' | 'read' | 'restored' | 'updated';
};

export type NotificationRealtimeSubscription = {
    unsubscribe: () => void;
};

export type NotificationRealtimeAdapter = {
    connect: (onEvent: (event: NotificationRealtimeEvent) => void) => NotificationRealtimeSubscription;
    transport: NotificationRealtimeTransport;
};

const noopSubscription: NotificationRealtimeSubscription = {
    unsubscribe: () => undefined,
};

export const createDisabledNotificationRealtimeAdapter = (): NotificationRealtimeAdapter => ({
    connect: () => noopSubscription,
    transport: 'polling',
});

export const notificationRealtimeAdapter = createDisabledNotificationRealtimeAdapter();
