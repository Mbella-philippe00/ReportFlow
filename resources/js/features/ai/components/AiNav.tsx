import { NavLink } from 'react-router-dom';

import { cn } from '@/utils/cn';

const aiNavItems = [
    { href: '/ai', label: 'Dashboard' },
    { href: '/ai/assistant', label: 'Assistant' },
    { href: '/ai/executive-summary', label: 'Executive Summary' },
    { href: '/ai/writing-improvement', label: 'Writing' },
    { href: '/ai/grammar-tone', label: 'Grammar & Tone' },
    { href: '/ai/action-items', label: 'Action Items' },
    { href: '/ai/risk-analysis', label: 'Risks' },
    { href: '/ai/missing-information', label: 'Missing Info' },
    { href: '/ai/quality-score', label: 'Quality Score' },
    { href: '/ai/workflow-recommendation', label: 'Workflow' },
    { href: '/ai/history', label: 'History' },
] as const;

export function AiNav() {
    return (
        <nav aria-label="AI navigation" className="overflow-x-auto pb-1">
            <div className="flex min-w-max gap-2 rounded-2xl border bg-surface p-2">
                {aiNavItems.map((item) => (
                    <NavLink
                        className={({ isActive }) =>
                            cn(
                                'rounded-xl px-3 py-2 text-sm font-medium text-muted-foreground outline-none transition hover:bg-muted hover:text-foreground focus:ring-2 focus:ring-primary',
                                isActive && 'bg-primary text-primary-foreground shadow-soft hover:bg-primary hover:text-primary-foreground',
                            )
                        }
                        end={item.href === '/ai'}
                        key={item.href}
                        to={item.href}
                    >
                        {item.label}
                    </NavLink>
                ))}
            </div>
        </nav>
    );
}
