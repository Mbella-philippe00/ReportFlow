import { Search } from 'lucide-react';
import type { FormEvent } from 'react';

import { IconButton, Input } from '@/components/ui';

export type SearchBarProps = {
    id?: string;
    label?: string;
    onChange: (value: string) => void;
    onSubmit?: (value: string) => void;
    placeholder?: string;
    value: string;
};

export function SearchBar({ id, label = 'Search', onChange, onSubmit, placeholder = 'Search…', value }: SearchBarProps) {
    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        onSubmit?.(value);
    };

    return (
        <form className="flex items-end gap-2" onSubmit={handleSubmit} role="search">
            <Input id={id} label={label} leftIcon={<Search aria-hidden="true" className="size-4" />} onChange={(event) => onChange(event.target.value)} placeholder={placeholder} value={value} />
            {onSubmit && <IconButton aria-label="Submit search" icon={<Search aria-hidden="true" className="size-4" />} type="submit" variant="outline" />}
        </form>
    );
}
