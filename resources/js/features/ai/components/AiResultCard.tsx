import { Check, Clipboard, Sparkles } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';

import { Badge, Button, Card, CardContent, CardDescription, CardHeader, CardTitle, Skeleton } from '@/components/ui';
import { getErrorMessage } from '@/lib/errors';
import { useToast } from '@/providers/ToastProvider';
import type { AiGeneration, AiHistoryItem } from '@/types';

import { formatAiDate, formatAiAction, getAiResultTitle } from '../utils/ai-utils';
import { AiMarkdown } from './AiMarkdown';

export type AiResultCardProps = {
    activeProviderLabel?: string;
    autoFocus?: boolean;
    fallbackUsed?: boolean;
    generation?: AiGeneration | AiHistoryItem | null;
    loading?: boolean;
    providerLabel?: string;
    title?: string;
};

export function AiResultCard({ activeProviderLabel, autoFocus = false, fallbackUsed = false, generation, loading = false, providerLabel, title }: AiResultCardProps) {
    const { notify } = useToast();
    const [copied, setCopied] = useState(false);
    const focusRef = useRef<HTMLDivElement>(null);
    const content = generation?.content ?? '';
    const resultTitle = title ?? (generation ? getAiResultTitle(generation.action) : 'AI result');
    const resolvedProviderLabel = providerLabel ?? generation?.provider;

    useEffect(() => {
        if (autoFocus && generation) {
            focusRef.current?.focus();
        }
    }, [autoFocus, generation]);

    const copyResult = async () => {
        if (!content) {
            return;
        }

        try {
            await navigator.clipboard.writeText(content);
            setCopied(true);
            notify({ intent: 'success', title: 'AI result copied', description: 'The generated response is on your clipboard.' });
            window.setTimeout(() => setCopied(false), 1800);
        } catch (error) {
            notify({ intent: 'error', title: 'Copy failed', description: getErrorMessage(error, 'Unable to copy the AI result.') });
        }
    };

    if (loading) {
        return (
            <Card aria-live="polite" aria-busy="true">
                <CardHeader className="flex-row items-start justify-between gap-3">
                    <div>
                        <CardTitle>Generating AI result</CardTitle>
                        <CardDescription>
                            {activeProviderLabel ? `ReportFlow is waiting for ${activeProviderLabel}.` : 'ReportFlow is waiting for the configured AI provider.'}
                        </CardDescription>
                    </div>
                    <Sparkles aria-hidden="true" className="size-5 animate-pulse text-primary" />
                </CardHeader>
                <CardContent className="grid gap-3">
                    <Skeleton className="h-4" />
                    <Skeleton className="h-4 w-11/12" />
                    <Skeleton className="h-4 w-9/12" />
                </CardContent>
            </Card>
        );
    }

    if (!generation) {
        return null;
    }

    return (
        <div ref={focusRef} tabIndex={-1}>
            <Card aria-live="polite">
                <CardHeader className="flex-row items-start justify-between gap-4">
                    <div>
                        <CardTitle className="flex flex-wrap items-center gap-2">
                            {resultTitle}
                            <Badge intent="primary">{formatAiAction(generation.action)}</Badge>
                            {fallbackUsed && <Badge intent="warning">Fallback used</Badge>}
                        </CardTitle>
                        <CardDescription>
                            {resolvedProviderLabel} {generation.model ? `? ${generation.model}` : ''} ? {formatAiDate(generation.created_at)}
                        </CardDescription>
                    </div>
                    <Button
                        aria-label="Copy AI result to clipboard"
                        leftIcon={copied ? <Check aria-hidden="true" className="size-4" /> : <Clipboard aria-hidden="true" className="size-4" />}
                        onClick={() => void copyResult()}
                        size="sm"
                        variant="outline"
                    >
                        {copied ? 'Copied' : 'Copy'}
                    </Button>
                </CardHeader>
                <CardContent>
                    {fallbackUsed && activeProviderLabel && (
                        <div className="mb-4 rounded-xl border border-warning/30 bg-warning/10 p-3 text-sm text-warning">
                            The active provider was {activeProviderLabel}; the backend returned this result through {resolvedProviderLabel}.
                        </div>
                    )}
                    <AiMarkdown content={content} />
                </CardContent>
            </Card>
        </div>
    );
}
