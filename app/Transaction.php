<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * A transaction is associated with a Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Mutate the Amount attribute for display
     *
     * @param  Integer $value
     * @return Float
     */
    public function getAmountAttribute($value)
    {
        return number_format($value / 100, 2);
    }
}
