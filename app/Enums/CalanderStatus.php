<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self INTERVIEW()
 * @method static self SHORTLISTED()
 * @method static self CONTACT_SIGNING()
 * @method static self CONTACTENDING()
 * @method static self CALLBACK()
 * @method static self get(int|string $value)
 */
class CalanderStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'INTERVIEW' => 1,
            'SHORTLISTED' => 2,
            'CONTACT_SIGNING' => 3,
            'CONTACTENDING' => 4,
            'CALLBACK' => 5,
        ];
    }

    public function title(): string|null
    {
        return match ($this->value) {
            1 => 'Interview',
            2 => 'Shortlisted',
            3 => 'Contactsigning',
            4 => 'Contactending',
            5 => 'Callback',
            default => null,
        };
    }

    public function message(): string|null
    {
        return match ($this->value) {
            1 => 'primary',
            2 => 'success',
            3 => 'warning',
            4 => 'dark',
            5 => 'info',
            default => null,
        };
    }
}
