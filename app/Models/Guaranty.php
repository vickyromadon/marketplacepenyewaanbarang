<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guaranty extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'type', 'file_id', 'transaction_id'];

    /**
     * Get the file that owns the Guaranty.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the transaction that owns the Guaranty.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }
}
