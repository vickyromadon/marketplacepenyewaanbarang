<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    const STATUS_PENDING        = 'pending';
    const STATUS_VERIFIED       = 'verified';
    const STATUS_FINISHED       = 'finished';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'transaction_id', 'price_owner', 'price_member',
    	'status', 'note', 'ammercement'
	];

	/**
     * Get the transaction that owns the transaction.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }
}
