import type { ReactNode } from 'react';

import { cn } from '@/utils/cn';

export type AiMarkdownProps = {
    className?: string;
    content: string;
};

const renderInline = (text: string): ReactNode[] => {
    const tokens = text.split(/(\*\*[^*]+\*\*|`[^`]+`)/g).filter(Boolean);

    return tokens.map((token, index) => {
        if (token.startsWith('**') && token.endsWith('**')) {
            return <strong key={`${token}-${index}`}>{token.slice(2, -2)}</strong>;
        }

        if (token.startsWith('`') && token.endsWith('`')) {
            return (
                <code className="rounded bg-muted px-1 py-0.5 text-[0.85em] text-foreground" key={`${token}-${index}`}>
                    {token.slice(1, -1)}
                </code>
            );
        }

        return token;
    });
};

export function AiMarkdown({ className, content }: AiMarkdownProps) {
    const lines = content.split(/\r?\n/);

    return (
        <div className={cn('space-y-2 text-sm leading-7 text-muted-foreground', className)}>
            {lines.map((line, index) => {
                const trimmed = line.trim();

                if (!trimmed) {
                    return <div aria-hidden="true" className="h-2" key={`blank-${index}`} />;
                }

                if (trimmed.startsWith('### ')) {
                    return <h4 className="pt-2 text-base font-semibold text-foreground" key={index}>{renderInline(trimmed.slice(4))}</h4>;
                }

                if (trimmed.startsWith('## ')) {
                    return <h3 className="pt-2 text-lg font-semibold text-foreground" key={index}>{renderInline(trimmed.slice(3))}</h3>;
                }

                if (trimmed.startsWith('# ')) {
                    return <h2 className="pt-2 text-xl font-semibold text-foreground" key={index}>{renderInline(trimmed.slice(2))}</h2>;
                }

                if (trimmed.startsWith('- ') || trimmed.startsWith('* ')) {
                    return (
                        <div className="flex gap-2" key={index}>
                            <span aria-hidden="true" className="mt-2 size-1.5 rounded-full bg-primary" />
                            <p>{renderInline(trimmed.slice(2))}</p>
                        </div>
                    );
                }

                if (/^\d+\.\s/.test(trimmed)) {
                    const marker = trimmed.match(/^\d+\./)?.[0] ?? '1.';

                    return (
                        <div className="flex gap-2" key={index}>
                            <span className="min-w-6 font-medium text-primary">{marker}</span>
                            <p>{renderInline(trimmed.replace(/^\d+\.\s/, ''))}</p>
                        </div>
                    );
                }

                return <p key={index}>{renderInline(trimmed)}</p>;
            })}
        </div>
    );
}
