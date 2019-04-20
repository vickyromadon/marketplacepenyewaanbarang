<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'product_id', 'user_id',
    	'rate', 'note'
	];

    /**
     * Get the user that owns the rating.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the product that owns the rating.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
