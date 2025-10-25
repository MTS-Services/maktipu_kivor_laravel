<?php

namespace App\Models;

use App\Models\BaseModel;

class ExchangeRateHistory extends BaseModel
{
    //

    protected $fillable = [
        'sort_order',
        'base_currency',
        'target_currency',
        'rate',
        'last_updated_at',


        'created_by',
        'updated_by',
        'deleted_by',

        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'last_updated_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function base()
    {
        return $this->belongsTo(Currency::class, 'base_currency', 'id');
    }

    public function target()
    {
        return $this->belongsTo(Currency::class, 'target_currency', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
