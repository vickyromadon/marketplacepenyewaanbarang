<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'terms_of_use', 'privacy_policy', 'location'];

    /**
     * Get the location that owns the company_profile.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }
}
