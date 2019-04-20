<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    const STATUS_EMPTY      = 'empty';
	const STATUS_PENDING  	= 'pending';
    const STATUS_APPROVED   = 'approved';
    const STATUS_REJECTED 	= 'rejected';
    const STATUS_CANCELED   = 'canceled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'code', 'start_rent', 'end_rent',
		'status', 'user_id', 'product_id',
        'reason', 'quantity'
	];

	/**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the product that owns the booking.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * Get the transaction for the booking.
     */
    public function transaction()
    {
        return $this->hasOne('App\Models\Transaction');
    }
}
