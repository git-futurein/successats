<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self CLOSE()
 * @method static self OPEN()
 */
class JobStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'CLOSE' => 0,
            'OPEN' => 1
        ];
    }

    public function title(): string|null
    {
        return match ($this->value) {
            0 => 'Close',
            1 => 'Open',
            default => null,
        };
    }
    public function message(): string|null
    {
        return match ($this->value) {
            0 => 'danger',
            1 => 'success',
            default => null,
        };
    }
}
