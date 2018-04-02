<?php

namespace App;

use App\Traits\HasAmount;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasAmount;

    protected $fillable = ['customer_id', 'amount', 'date'];

    protected $casts = [
        'customer_id' => 'integer',
        'date'        => 'date:Y-m-d'
    ];

    /**
     * A transaction is associated with a Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
