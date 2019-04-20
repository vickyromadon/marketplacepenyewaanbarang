<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	const STATUS_PUBLISH  	    = 'publish';
    const STATUS_UNPUBLISH      = 'unpublish';
    const STATUS_BLOCKIR        = 'blockir';

    const TIME_PERIODE_DAY      = 'Day';
    const TIME_PERIODE_WEEK     = 'Week';
    const TIME_PERIODE_MONTH    = 'Month';
    const TIME_PERIODE_YEAR     = 'Year';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'categoty_id', 'user_id',
    	'name', 'quantity', 'price',
    	'stock', 'description', 'deposite',
    	'time_periode', 'status', 'note',
	];

    /**
     * Get the file that owns the product.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the user that owns the Products.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the sub_category that owns the Products.
     */
    public function sub_category()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    /**
     * Get the location that owns the product.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    /**
     * Get the album that owns the product.
     */
    public function albums()
    {
        return $this->hasMany('App\Models\Album');
    }

    /**
     * Get the report that owns the product.
     */
    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }

    /**
     * Get the booking that owns the product.
     */
    public function booking()
    {
        return $this->hasOne('App\Models\Booking');
    }

    /**
     * Get the ratings for the product.
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }
}
