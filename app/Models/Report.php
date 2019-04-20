<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	const CONTENT_OPTION_1 = 'Product indicated fraud';
	const CONTENT_OPTION_2 = 'Product not worth advertised';
	const CONTENT_OPTION_3 = 'This product is duplicate with other products';
	const CONTENT_OPTION_4 = 'Fake product information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'content', 'user_id', 'product_id'
	];

	/**
     * Get the user that owns the report.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

	/**
     * Get the product that owns the report.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
