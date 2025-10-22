<?php

namespace App\Models;

use App\Enums\AdminStatus;
use App\Enums\OtpType;
use App\Models\AuthBaseModel;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Admin extends AuthBaseModel
{
    use TwoFactorAuthenticatable;
    protected $guard = 'admin';

    protected $fillable = [
        'sort_order',
        'name',
        'email',
        'email_verified_at',
        'two_factor_confirmed_at',
        'phone',
        'phone_verified_at',
        'password',
        'avatar',
        'status',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'last_login_at',
        'last_login_ip',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_synced_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'status' => AdminStatus::class,
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', AdminStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', AdminStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        });

        return $query;
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === AdminStatus::ACTIVE;
    }

    public function activate(): void
    {
        $this->update(['status' => AdminStatus::ACTIVE]);
    }

    public function deactivate(): void
    {
        $this->update(['status' => AdminStatus::INACTIVE]);
    }

    public function suspend(): void
    {
        $this->update(['status' => AdminStatus::SUSPENDED]);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }



    public function otpVerifications()
    {
        return $this->morphMany(OtpVerification::class, 'verifiable');
    }

    /**
     * Get the latest OTP verification of a specific type.
     */
    public function latestOtp(OtpType $type)
    {
        return $this->otpVerifications()
            ->where('type', $type)
            ->latest()
            ->first();
    }

    /**
     * Create a new OTP verification.
     */
    public function createOtp(OtpType $type, int $expiresInMinutes = 10): OtpVerification
    {
        // Invalidate old OTPs of same type
        $this->otpVerifications()
            ->where('type', $type)
            ->whereNull('verified_at')
            ->update(['expires_at' => now()]);

        $otp = sprintf('%06d', mt_rand(0, 999999));

        return $this->otpVerifications()->create([
            'type' => $type,
            'code' => $otp,
            'expires_at' => now()->addMinutes($expiresInMinutes),
            'attempts' => 0,
        ]);
    }

    /**
     * Mark email as verified.
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    /**
     * Mark phone as verified.
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => now(),
        ])->save();
    }
}
