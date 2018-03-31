<?php

namespace App;

use App\Traits\HasAmount;
use Illuminate\Database\Eloquent\Model;

class DailyTransactionTotal extends Model
{
    use HasAmount;

    protected $fillable = ['amount'];
}
