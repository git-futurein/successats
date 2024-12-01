<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DRAFT()
 * @method static self PENDING()
 * @method static self APPROVED()
 * @method static self DELETED()
 * @method static self CANCLE()
 */
class Status extends Enum
{
    protected static function values(): array
    {
        return [
            'DRAFT' => 0,
            'PENDING' => 1,
            'APPROVED' => 2,
            'DELETED' => 3,
            'CANCLE' => 4,
        ];
    }

    public function title(): string|null
    {
        return match ($this->value) {
            0 => 'Draft',
            1 => 'Pending',
            2 => 'Approved',
            3 => 'Deleted',
            4 => 'Cancle',
            default => null,
        };
    }
    public function message(): string|null
    {
        return match ($this->value) {
            0 => 'muted',
            1 => 'warning',
            2 => 'success',
            3 => 'danger',
            4 => 'black-50',
            default => null,
        };
    }
}
