import { Button, Select } from '@/components/ui';
import type { SelectOption } from '@/components/ui';

export type FilterDefinition = {
    id: string;
    label: string;
    onChange: (value: string) => void;
    options: readonly SelectOption[];
    placeholder?: string;
    value: string;
};

export type FilterBarProps = {
    clearLabel?: string;
    filters: readonly FilterDefinition[];
    onClear?: () => void;
};

export function FilterBar({ clearLabel = 'Clear filters', filters, onClear }: FilterBarProps) {
    return (
        <div className="grid w-full gap-3 sm:grid-cols-2 xl:flex xl:w-auto xl:items-end" role="group" aria-label="Filters">
            {filters.map((filter) => (
                <Select
                    className="min-w-36"
                    key={filter.id}
                    label={filter.label}
                    onChange={(event) => filter.onChange(event.target.value)}
                    options={filter.options}
                    placeholder={filter.placeholder}
                    value={filter.value}
                />
            ))}
            {onClear && <Button className="self-end" onClick={onClear} variant="outline">{clearLabel}</Button>}
        </div>
    );
}
