<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'email', 'content', 'name', 'phone'
    ];

    /**
     * Get the user that owns the Messages.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
