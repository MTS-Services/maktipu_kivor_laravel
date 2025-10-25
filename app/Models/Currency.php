<?php

namespace App\Models;

use App\Enums\CurrencyStatus;
use App\Models\BaseModel;

class Currency extends BaseModel
{
    protected $fillable = [
        'sort_order',
        'code',
        'symbol',
        'name',
        'exchange_rate',
        'decimal_places',
        'status',
        'is_default',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'status' => CurrencyStatus::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

     //

     /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

     public function scopeActive($query)
    {
        return $query->where('status', CurrencyStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', CurrencyStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }


}
