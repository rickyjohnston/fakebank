<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name'];

    /**
     * A Customer can make Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
