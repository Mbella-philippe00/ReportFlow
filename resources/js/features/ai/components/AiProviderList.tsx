import { Bot, CheckCircle2, XCircle } from 'lucide-react';

import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import type { AiProvider } from '@/types';

export type AiProviderListProps = {
    providers: AiProvider[];
};

export function AiProviderList({ providers }: AiProviderListProps) {
    return (
        <div className="grid gap-4 md:grid-cols-2">
            {providers.map((provider) => (
                <Card className={provider.active ? 'border-primary/50' : undefined} key={provider.name}>
                    <CardHeader className="flex-row items-start justify-between gap-3">
                        <div>
                            <CardTitle className="flex flex-wrap items-center gap-2">
                                <Bot aria-hidden="true" className="size-5 text-primary" />
                                {provider.label}
                                {provider.active && <Badge intent="primary">Active</Badge>}
                            </CardTitle>
                            <CardDescription>{provider.default_model ?? 'No default model reported'}</CardDescription>
                        </div>
                        <Badge intent={provider.configured ? 'success' : 'warning'}>
                            {provider.configured ? 'Configured' : 'Unavailable'}
                        </Badge>
                    </CardHeader>
                    <CardContent className="grid gap-3">
                        <div className="flex items-center gap-2 text-sm text-muted-foreground">
                            {provider.configured ? <CheckCircle2 aria-hidden="true" className="size-4 text-success" /> : <XCircle aria-hidden="true" className="size-4 text-warning" />}
                            <span>{provider.configured ? 'Ready for authenticated AI requests.' : 'Provider is visible but not configured.'}</span>
                        </div>
                        {provider.models.length > 0 && (
                            <div className="flex flex-wrap gap-2" aria-label={`${provider.label} models`}>
                                {provider.models.map((model) => (
                                    <Badge intent={model === provider.default_model ? 'primary' : 'neutral'} key={model}>{model}</Badge>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            ))}
        </div>
    );
}
