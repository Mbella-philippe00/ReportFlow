import { Download } from 'lucide-react';
import { useState } from 'react';

import { Button, Tooltip } from '@/components/ui';
import { env } from '@/config/env';
import { useAuthStore } from '@/stores/auth.store';
import type { AnalyticsExportOptions } from '@/types';

export type AnalyticsExportActionProps = {
    dataset?: string;
    exportOptions?: AnalyticsExportOptions;
    loading?: boolean;
};

const formatLabels: Record<string, string> = {
    csv: 'CSV',
    pdf: 'PDF',
    xlsx: 'Excel',
};

export function AnalyticsExportAction({ dataset = 'executive', exportOptions, loading = false }: AnalyticsExportActionProps) {
    const token = useAuthStore((state) => state.token);
    const [activeFormat, setActiveFormat] = useState<string | null>(null);
    const supported = Boolean(exportOptions?.supported);
    const message = exportOptions?.message ?? 'Loading export availability from the Analytics API.';
    const formats = exportOptions?.available_formats ?? [];

    const download = async (format: string) => {
        setActiveFormat(format);

        try {
            const baseUrl = env.apiBaseUrl.endsWith('/') ? env.apiBaseUrl.slice(0, -1) : env.apiBaseUrl;
            const response = await fetch(baseUrl + '/analytics/export?format=' + encodeURIComponent(format) + '&dataset=' + encodeURIComponent(dataset), {
                headers: {
                    Accept: '*/*',
                    ...(token ? { Authorization: 'Bearer ' + token } : {}),
                },
            });

            if (!response.ok) {
                throw new Error('Analytics export failed.');
            }

            const blob = await response.blob();
            const disposition = response.headers.get('content-disposition') ?? '';
            const match = disposition.match(/filename=([^;]+)/i);
            const filename = match?.[1]?.replaceAll(String.fromCharCode(34), '') ?? 'reportflow-analytics.' + format;
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(url);
        } finally {
            setActiveFormat(null);
        }
    };

    if (!supported) {
        return (
            <Tooltip content={message}>
                <span className='inline-flex' tabIndex={0}>
                    <Button disabled leftIcon={<Download aria-hidden='true' className='size-4' />} loading={loading} variant='outline'>
                        Exports unavailable
                    </Button>
                </span>
            </Tooltip>
        );
    }

    return (
        <div className='flex flex-wrap items-center gap-2'>
            {formats.map((format) => (
                <Button
                    key={format}
                    leftIcon={<Download aria-hidden='true' className='size-4' />}
                    loading={activeFormat === format}
                    onClick={() => void download(format)}
                    size='sm'
                    variant='outline'
                >
                    {formatLabels[format] ?? format.toUpperCase()}
                </Button>
            ))}
        </div>
    );
}
