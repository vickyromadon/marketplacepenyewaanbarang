<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{   
    const METHODE_PAYMENT_REKBER    = 'rekber';
    const METHODE_PAYMENT_COD       = 'cod';

    const STATUS_PENDING            = 'pending';
    const STATUS_APPROVED           = 'approved';
    const STATUS_REJECTED           = 'rejected';
    const STATUS_CANCELED           = 'canceled';
    const STATUS_VERIFIED           = 'verified';

    const STATUS_PAYMENT_PENDING    = 'pending';
    const STATUS_PAYMENT_APPROVED   = 'approved';
    const STATUS_PAYMENT_REJECTED   = 'rejected';
    const STATUS_PAYMENT_EMPTY      = 'empty';
    const STATUS_PAYMENT_VERIFIED   = 'verified';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'account_name_of_sender',
    	'account_number_of_sender',
    	'bank_name_of_sender', 'payment_method',
    	'transfer_date', 'status',
    	'booking_id', 'file_id', 'bank_id', 'status_payment'
    ];

    /**
     * Get the documents for the file.
     */
    public function document()
    {
        return $this->hasMany('App\Models\Document');
    }

    /**
     * Get the file that owns the Transaction.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the bank that owns the transaction.
     */
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    /**
     * Get the booking that owns the transaction.
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }

    /**
     * Get the guaranties for the transaction.
     */
    public function guaranties()
    {
        return $this->hasMany('App\Models\Guaranty');
    }

    /**
     * Get the delivery for the transaction.
     */
    public function delivery()
    {
        return $this->hasOne('App\Models\Delivery');
    }

    /**
     * Get the refund for the transaction.
     */
    public function refund()
    {
        return $this->hasOne('App\Models\Refund');
    }
}
