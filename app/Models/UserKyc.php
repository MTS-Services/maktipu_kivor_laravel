<?php

namespace App\Models;

use App\Enums\KycStatus;
use Illuminate\Database\Eloquent\Model;

class UserKyc extends Model
{

    protected $fillable = [
        'user_id',
        'kyc_status',
        'kyc_submitted_at',
        'kyc_approved_at',


        'created_type',
        'updated_type',
        'deleted_type',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    protected $casts = [
        'kyc_submitted_at' => 'datetime',
        'kyc_approved_at' => 'datetime',
        'kyc_status' => KycStatus::class,
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Helper methods
     */
    public function isApproved(): bool
    {
        return $this->kyc_status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->kyc_status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->kyc_status === 'rejected';
    }

    public function getKycStatusLabelAttribute(): string
    {
        return $this->kyc_status->label();
    }

    public function getKycStatusColorAttribute(): string
    {
        return $this->kyc_status->color();
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->appends = array_merge(parent::getAppends(), [
            'kyc_status_label',
            'kyc_status_color',
        ]);
    }
}
