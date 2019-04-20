<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reversion extends Model
{   
    const STATUS_EMPTY      = 'empty';
    const STATUS_PENDING    = 'pending';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_ARRIVED    = 'arrived';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = 	[
		'delivery_id', 'name', 'phone',
		'address', 'status', 'file_id',
		'delivery_date', 'arrive_date',
	];

	/**
     * Get the file that owns the Document.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the delivery that owns the Reversion.
     */
    public function delivery()
    {
        return $this->belongsTo('App\Models\Delivery');
    }
}
