<?php

namespace App\Enums;

enum LanguageDirections: string
{
    case RTL = 'rtl';
    case LTR = 'ltr';

    public function label(): string
    {
        return match($this) {
            self::RTL => 'RTL',
            self::LTR => 'LTR',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::RTL => 'badge-success',
            self::LTR => 'badge-info',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
