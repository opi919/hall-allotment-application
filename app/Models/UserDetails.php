<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $guarded = [];

    public function bill()
    {
        return $this->hasOne(Bill::class, 'username', 'username');
    }
}
