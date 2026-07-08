import { ChevronLeft, ChevronRight } from 'lucide-react';

import { Button } from '@/components/ui/Button';
import { IconButton } from '@/components/ui/IconButton';
import { cn } from '@/utils/cn';

export type PaginationProps = {
    className?: string;
    onPageChange: (page: number) => void;
    page: number;
    pageCount: number;
};

const getPageWindow = (page: number, pageCount: number): number[] => {
    const start = Math.max(1, page - 2);
    const end = Math.min(pageCount, start + 4);

    return Array.from({ length: end - start + 1 }, (_, index) => start + index);
};

export function Pagination({ className, onPageChange, page, pageCount }: PaginationProps) {
    const pages = getPageWindow(page, pageCount);
    const canGoPrevious = page > 1;
    const canGoNext = page < pageCount;

    return (
        <nav aria-label="Pagination" className={cn('flex items-center justify-between gap-3', className)}>
            <IconButton
                aria-label="Go to previous page"
                disabled={!canGoPrevious}
                icon={<ChevronLeft aria-hidden="true" className="size-4" />}
                onClick={() => onPageChange(page - 1)}
                variant="outline"
            />
            <div className="flex items-center gap-1">
                {pages.map((pageNumber) => (
                    <Button
                        aria-current={pageNumber === page ? 'page' : undefined}
                        key={pageNumber}
                        onClick={() => onPageChange(pageNumber)}
                        size="sm"
                        variant={pageNumber === page ? 'primary' : 'ghost'}
                    >
                        {pageNumber}
                    </Button>
                ))}
            </div>
            <IconButton
                aria-label="Go to next page"
                disabled={!canGoNext}
                icon={<ChevronRight aria-hidden="true" className="size-4" />}
                onClick={() => onPageChange(page + 1)}
                variant="outline"
            />
        </nav>
    );
}
