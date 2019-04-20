<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the bank that owns the admin.
     */
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    /**
     * Get the file that owns the admin.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
