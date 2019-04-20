<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['filename', 'title', 'path', 'extension', 'size'];

    /**
     * Get the admins for the file.
     */
    public function admins()
    {
        return $this->hasMany('App\Models\Admin');
    }

    /**
     * Get the users for the file.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * Get the products for the file.
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * Get the couriers for the file.
     */
    public function couriers()
    {
        return $this->hasMany('App\Models\Courier');
    }

    /**
     * Get the albums for the file.
     */
    public function albums()
    {
        return $this->hasMany('App\Models\Album');
    }

    /**
     * Get the documents for the file.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

    /**
     * Get the transactions for the file.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    /**
     * Get the guaranties for the file.
     */
    public function guaranties()
    {
        return $this->hasMany('App\Models\Guaranty');
    }

    /**
     * Get the deliveries for the file.
     */
    public function deliveries()
    {
        return $this->hasMany('App\Models\Delivery');
    }

    /**
     * Get the reversions for the file.
     */
    public function reversions()
    {
        return $this->hasMany('App\Models\Reversion');
    }

    /**
     * Get the identity_cards for the file.
     */
    public function identity_cards()
    {
        return $this->hasMany('App\Models\IdentityCard');
    }
}
