import { useId, useMemo, useState } from 'react';
import type { ReactNode } from 'react';

import { cn } from '@/utils/cn';

export type TabItem = {
    content: ReactNode;
    disabled?: boolean;
    label: string;
    value: string;
};

export type TabsProps = {
    defaultValue?: string;
    items: readonly TabItem[];
    onValueChange?: (value: string) => void;
    value?: string;
};

export function Tabs({ defaultValue, items, onValueChange, value }: TabsProps) {
    const generatedId = useId();
    const firstEnabledValue = items.find((item) => !item.disabled)?.value;
    const [internalValue, setInternalValue] = useState(defaultValue ?? firstEnabledValue ?? '');
    const activeValue = value ?? internalValue;
    const activeItem = useMemo(() => items.find((item) => item.value === activeValue) ?? items[0], [activeValue, items]);

    const activateTab = (nextValue: string) => {
        setInternalValue(nextValue);
        onValueChange?.(nextValue);
    };

    const moveFocus = (currentIndex: number, direction: 1 | -1) => {
        const enabledItems = items.filter((item) => !item.disabled);
        const currentItem = items[currentIndex];
        const enabledIndex = enabledItems.findIndex((item) => item.value === currentItem?.value);
        const nextItem = enabledItems[(enabledIndex + direction + enabledItems.length) % enabledItems.length];

        if (nextItem) {
            activateTab(nextItem.value);
        }
    };

    return (
        <div className="grid gap-4">
            <div aria-label="Tabs" className="flex gap-1 rounded-xl bg-muted p-1" role="tablist">
                {items.map((item, index) => {
                    const selected = item.value === activeValue;
                    const tabId = `${generatedId}-${item.value}-tab`;
                    const panelId = `${generatedId}-${item.value}-panel`;

                    return (
                        <button
                            aria-controls={panelId}
                            aria-selected={selected}
                            className={cn(
                                'rounded-lg px-3 py-2 text-sm font-medium text-muted-foreground transition focus:outline-none focus:ring-2 focus:ring-primary disabled:pointer-events-none disabled:opacity-50',
                                selected && 'bg-surface text-foreground shadow-soft',
                            )}
                            disabled={item.disabled}
                            id={tabId}
                            key={item.value}
                            onClick={() => activateTab(item.value)}
                            onKeyDown={(event) => {
                                if (event.key === 'ArrowRight') {
                                    event.preventDefault();
                                    moveFocus(index, 1);
                                }
                                if (event.key === 'ArrowLeft') {
                                    event.preventDefault();
                                    moveFocus(index, -1);
                                }
                            }}
                            role="tab"
                            tabIndex={selected ? 0 : -1}
                            type="button"
                        >
                            {item.label}
                        </button>
                    );
                })}
            </div>
            {activeItem && (
                <div
                    aria-labelledby={`${generatedId}-${activeItem.value}-tab`}
                    className="outline-none"
                    id={`${generatedId}-${activeItem.value}-panel`}
                    role="tabpanel"
                    tabIndex={0}
                >
                    {activeItem.content}
                </div>
            )}
        </div>
    );
}
