<?php

namespace App\Models;

use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;
use App\Models\BaseModel;

class Language extends BaseModel
{
    protected $fillable = [
        'sort_order',
        'locale',
        'name',
        'native_name',
        'flag_icon',
        'status',
        'is_default',
        'direction',
        'country_code',


        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'status' => LanguageStatus::class,
        'direction' => LanguageDirections::class,

    ];
    public function scopeRTL($query)
    {
        return $query->where('rtl', LanguageDirections::RTL);
    }

    public function scopeLTR($query)
    {
        return $query->where('LTR', LanguageDirections::LTR);
    }
    public function scopeActive($query)
    {
        return $query->where('status', LanguageStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', LanguageStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('native_name', 'like', "%{$search}%")
                ->orWhere('locale', 'like', "%{$search}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['direction'] ?? null, function ($query, $direction) {
            $query->where('direction', $direction);
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
    public function getDerectionLabelAttribute(): string
    {
        return $this->direction->label();
    }

    public function getDerectionColorAttribute(): string
    {
        return $this->direction->color();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
            'direction_label',
            'direction_color',
        ]);
    }
}
