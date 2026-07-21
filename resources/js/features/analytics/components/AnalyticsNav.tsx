import { NavLink } from 'react-router-dom';

import { Card } from '@/components/ui';
import { cn } from '@/utils/cn';

import { analyticsNavItems } from '../utils/analytics-utils';

export function AnalyticsNav() {
    return (
        <Card className="p-2">
            <nav aria-label="Analytics sections" className="flex flex-wrap gap-1">
                {analyticsNavItems.map((item) => (
                    <NavLink
                        className={({ isActive }) =>
                            cn(
                                'rounded-xl px-3 py-2 text-sm font-medium text-muted-foreground outline-none transition hover:bg-muted hover:text-foreground focus:ring-2 focus:ring-primary',
                                isActive && 'bg-primary text-primary-foreground shadow-soft hover:bg-primary hover:text-primary-foreground',
                            )
                        }
                        end={item.path === '/analytics'}
                        key={item.path}
                        to={item.path}
                    >
                        {item.label}
                    </NavLink>
                ))}
            </nav>
        </Card>
    );
}
