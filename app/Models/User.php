<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{   
    const STATUS_UNCONFIRM  = 'unconfirm';
    const STATUS_CONFIRM    = 'confirm';
    const STATUS_NOT_ACTIVE = 'not active';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 
        'phone', 'age', 'religion', 
        'gender', 'birthdate', 'birthplace', 
        'privilege', 'status',
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
     * Get the bank that owns the user.
     */
    public function banks()
    {
        return $this->hasMany('App\Models\Bank');
    }

    /**
     * Get the file that owns the user.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the messages for the user.
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    /**
     * Get the products for the user.
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * Get the location that owns the user.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    /**
     * Get the report that owns the user.
     */
    public function report()
    {
        return $this->hasOne('App\Models\Report');
    }

    /**
     * Get the bookings that owns the user.
     */
    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }

    /**
     * Get the ratings for the user.
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    /**
     * Get the identity_card that owns the user.
     */
    public function identity_card()
    {
        return $this->belongsTo('App\Models\IdentityCard');
    }
}
