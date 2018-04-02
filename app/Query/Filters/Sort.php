<?php

namespace App\Query\Filters;

use Illuminate\Database\Eloquent\Builder;

class Sort implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param    Builder   $builder
     * @param    mixed     $value
     * @return   Builder   $builder
     */
    public static function apply(Builder $builder, $value)
    {
        if ($value === 'amount' || $value === 'date') {
            return $builder->orderBy($value, 'desc');
        }

        return $builder;
    }
}
