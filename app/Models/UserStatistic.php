<?php

namespace App\Models;

use App\Models\BaseModel;

class UserStatistic extends BaseModel
{
      protected $fillable = [
        'sort_order',
        'user_id',
        'total_orders_as_buyer',
        'total_spent',
        'total_orders_as_seller',
        'total_earned',
        'average_rating_as_seller',
        'total_reviews_as_seller',

        'created_type',
        'updated_type',
        'deleted_type',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'average_rating_as_seller' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
