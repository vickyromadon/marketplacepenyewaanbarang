<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the file that owns the Courier.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
