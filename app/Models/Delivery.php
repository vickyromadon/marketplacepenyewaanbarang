<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{

    const STATUS_PENDING    = 'pending';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_ARRIVED    = 'arrived';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = 	[
		'transaction_id', 'address', 'arrive_date',
		'delivery_date', 'status', 'file_id',
	];

	/**
     * Get the transaction that owns the Delivery.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }

    /**
     * Get the file that owns the Document.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the reversion for the transaction.
     */
    public function reversion()
    {
        return $this->hasOne('App\Models\Reversion');
    }
}
