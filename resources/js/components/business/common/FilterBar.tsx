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
        <div className="flex flex-col gap-3 md:flex-row md:items-end" role="group" aria-label="Filters">
            {filters.map((filter) => (
                <Select
                    key={filter.id}
                    label={filter.label}
                    onChange={(event) => filter.onChange(event.target.value)}
                    options={filter.options}
                    placeholder={filter.placeholder}
                    value={filter.value}
                />
            ))}
            {onClear && <Button onClick={onClear} variant="outline">{clearLabel}</Button>}
        </div>
    );
}
