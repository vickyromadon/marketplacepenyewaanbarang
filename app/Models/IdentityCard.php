<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityCard extends Model
{
    const STATUS_PENDING            = 'pending';
    const STATUS_APPROVED           = 'approved';
    const STATUS_REJECTED           = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'note', 'status', 'file_id'];

    /**
     * Get the file that owns the IdentityCard.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the user that owns the identityCard.
     */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
