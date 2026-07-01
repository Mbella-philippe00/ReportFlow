<?php

namespace App\Enums;

enum ReportStatus: string
{
    case DRAFT = 'draft';

    case SUBMITTED = 'submitted';

    case MANAGER_APPROVED = 'manager_approved';

    case GENERATED = 'generated';

    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::SUBMITTED => 'Soumis',
            self::MANAGER_APPROVED => 'Pré-validé',
            self::GENERATED => 'Validé',
            self::REJECTED => 'Rejeté',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::SUBMITTED => 'warning',
            self::MANAGER_APPROVED => 'info',
            self::GENERATED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
