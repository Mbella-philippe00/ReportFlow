import { FileText, RotateCcw } from 'lucide-react';

import { Badge, Button, Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import type { AiHistoryItem } from '@/types';

import { formatAiAction, formatRelativeAiTime, groupAiHistoryByDate } from '../utils/ai-utils';

export type AiHistoryListProps = {
    items: AiHistoryItem[];
    onSelect: (item: AiHistoryItem) => void;
};

export function AiHistoryList({ items, onSelect }: AiHistoryListProps) {
    const groups = groupAiHistoryByDate(items);

    return (
        <div className="grid gap-6">
            {groups.map((group) => (
                <section className="grid gap-3" key={group.label}>
                    <h2 className="text-sm font-semibold uppercase tracking-wide text-muted-foreground">{group.label}</h2>
                    <div className="grid gap-3">
                        {group.items.map((item) => (
                            <Card key={item.id}>
                                <CardHeader className="flex-row items-start justify-between gap-4">
                                    <div>
                                        <CardTitle className="flex flex-wrap items-center gap-2 text-base">
                                            {formatAiAction(item.action)}
                                            {item.persisted && <Badge intent="success">Persisted</Badge>}
                                        </CardTitle>
                                        <CardDescription>
                                            {item.report ? `${item.report.department ?? 'Report'} · ${item.report.week ?? 'Unknown week'}` : 'No report reference'} · {formatRelativeAiTime(item.created_at)}
                                        </CardDescription>
                                    </div>
                                    <Button
                                        aria-label={`Reopen ${formatAiAction(item.action)} result`}
                                        leftIcon={<RotateCcw aria-hidden="true" className="size-4" />}
                                        onClick={() => onSelect(item)}
                                        size="sm"
                                        variant="outline"
                                    >
                                        Reopen
                                    </Button>
                                </CardHeader>
                                <CardContent>
                                    <div className="flex gap-3 text-sm text-muted-foreground">
                                        <FileText aria-hidden="true" className="mt-0.5 size-4 shrink-0" />
                                        <p className="line-clamp-2">{item.content}</p>
                                    </div>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </section>
            ))}
        </div>
    );
}
