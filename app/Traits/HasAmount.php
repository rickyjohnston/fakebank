<?php

namespace App\Traits;

trait HasAmount
{
    /**
     * Mutate the Amount attribute for display
     *
     * @param  Integer $value
     * @return Float
     */
    public function getAmountAttribute($value)
    {
        return (double) number_format($value / 100, 2);
    }
}