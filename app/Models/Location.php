<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'latitude', 'longitude'];

    /**
    * Get the company_profile for the location.
    */
    public function company_profile()
    {
        return $this->hasOne('App\Models\CompanyProfile');
    }

    /**
    * Get the user for the location.
    */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    /**
    * Get the product for the location.
    */
    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
