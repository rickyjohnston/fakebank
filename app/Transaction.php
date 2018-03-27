<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
