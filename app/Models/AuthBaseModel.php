<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthBaseModel extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $appends = [
        'modified_image',

        'verify_label',
        'verify_color',

        'created_at_human',
        'updated_at_human',
        'deleted_at_human',

        'created_at_formatted',
        'updated_at_formatted',
        'deleted_at_formatted',
        'last_synced_at_human',
    ];

    /* ================================================================
     * *** Relations ***
     ================================================================ */

    public function creater_admin()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select(['name', 'id', 'status']);
    }

    public function updater_admin()
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id')->select(['name', 'id', 'status']);
    }

    public function deleter_admin()
    {
        return $this->belongsTo(Admin::class, 'deleted_by', 'id')->select(['name', 'id', 'status']);
    }

    public function creater()
    {
        return $this->morphTo();
    }

    public function updater()
    {
        return $this->morphTo();
    }

    public function deleter()
    {
        return $this->morphTo();
    }

    /* ================================================================
     * *** Accessors ***
     ================================================================ */

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at ? Carbon::parse($this->created_at)->format('d M, Y h:i A') : 'N/A';
    }

    public function getUpdatedAtFormattedAttribute(): string
    {
        return $this->updated_at && $this->updated_at != $this->created_at ? Carbon::parse($this->updated_at)->format('d M, Y h:i A') : 'N/A';
    }

    public function getDeletedAtFormattedAttribute(): string
    {
        return $this->deleted_at ? Carbon::parse($this->deleted_at)->format('d M, Y h:i A') : 'N/A';
    }

    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedAtHumanAttribute(): string
    {
        return $this->updated_at && $this->updated_at != $this->created_at ? $this->updated_at->diffForHumans() : 'N/A';
    }

    public function getDeletedAtHumanAttribute(): string
    {
        return $this->deleted_at ? $this->deleted_at->diffForHumans() : 'N/A';
    }

    // Verify Accessors
    public function getVerifyLabelAttribute()
    {
        return $this->email_verified_at ? 'Verified' : 'Unverified';
    }

    public function getVerifyColorAttribute()
    {
        return $this->email_verified_at ? 'badge-success' : 'badge-error';
    }

    public function getModifiedImageAttribute()
    {
        return auth_storage_url($this->image);
    }

    /* ================================================================
     * *** Scopes ***
     ================================================================ */

    // Verified scope
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    /* ================================================================
     * *** Mutators ***
     ================================================================ */

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
