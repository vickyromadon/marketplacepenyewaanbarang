<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_id', 'transaction_id'];

    /**
     * Get the file that owns the Document.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the transaction that owns the Document.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }
}
