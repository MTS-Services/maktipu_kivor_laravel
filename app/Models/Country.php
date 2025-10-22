<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'sort_order',
        'name',
        'code',
        'phone_code',
        'currency',
        'is_active',

        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
