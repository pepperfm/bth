<?php

declare(strict_types=1);

namespace App\Enums;

enum StatusEnum: string
{
    case AVAILABLE = 'available';

    case UNAVAILABLE = 'unavailable';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Доступен',
            self::UNAVAILABLE => 'Не доступен',
        };
    }
}
