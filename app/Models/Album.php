<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * Get the file that owns the album.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the product for the album.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
