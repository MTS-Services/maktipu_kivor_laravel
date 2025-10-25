<?php

namespace App\Enums;

enum UserAccountStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
    case BANNED = 'banned';
    case PENDINGVERIFICATION = 'pending_verification';


    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::SUSPENDED => 'Suspended',
            self::BANNED => 'Banned',
            self::PENDINGVERIFICATION => 'Pending Verification',
        };
    }


    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'badge-success',
            self::INACTIVE => 'badge-secondary',
            self::SUSPENDED => 'badge-warning',
            self::BANNED => 'badge-danger',
            self::PENDINGVERIFICATION => 'badge-info',
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
