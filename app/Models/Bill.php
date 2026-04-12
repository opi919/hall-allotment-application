<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $guarded = [];

    public function userDetails()
    {
        return $this->belongsTo(UserDetails::class, 'username', 'username');
    }
}
