import { Link, useLocation } from 'react-router-dom';

import { navigationItems } from '@/config/navigation';

const formatSegment = (segment: string): string =>
    segment
        .split('-')
        .filter(Boolean)
        .map((part) => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)
        .join(' ');

const navigationLabels = new Map(navigationItems.map((item) => [item.href, item.label]));

export function Breadcrumb() {
    const location = useLocation();
    const segments = location.pathname.split('/').filter(Boolean);

    if (segments.length === 0) {
        return null;
    }

    const crumbs = segments.map((segment, index) => {
        const href = `/${segments.slice(0, index + 1).join('/')}`;

        return {
            href,
            label: navigationLabels.get(href) ?? formatSegment(segment),
        };
    });

    return (
        <nav aria-label="Breadcrumb" className="hidden min-w-0 items-center text-sm text-muted-foreground md:flex">
            <ol className="flex min-w-0 items-center gap-2">
                <li>
                    <Link className="rounded-md px-1.5 py-1 transition hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary" to="/dashboard">
                        Home
                    </Link>
                </li>
                {crumbs.map((crumb, index) => {
                    const isLast = index === crumbs.length - 1;

                    return (
                        <li className="flex min-w-0 items-center gap-2" key={crumb.href}>
                            <span aria-hidden="true" className="text-muted-foreground/60">/</span>
                            {isLast ? (
                                <span aria-current="page" className="truncate font-medium text-foreground">
                                    {crumb.label}
                                </span>
                            ) : (
                                <Link
                                    className="truncate rounded-md px-1.5 py-1 transition hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                                    to={crumb.href}
                                >
                                    {crumb.label}
                                </Link>
                            )}
                        </li>
                    );
                })}
            </ol>
        </nav>
    );
}

