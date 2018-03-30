<?php

namespace App\Query;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TransactionQuery
{
    /**
     * Apply the provided filters to a query on the Transaction model
     *
     * @param   Request   $filters   All the filters to add to this query
     * @return \Illuminate\Support\Collection
     */
    public function apply(Request $filters)
    {
        $query = (new Transaction)->newQuery();

        $query = $this->applyDecoratorsFromRequest($filters, $query);

        return $this->getResults($query, $this->getLimit($filters->limit ?? 5));
    }

    /**
     * Get all of the filters from the request and apply them to the query.
     *
     * @param   Request   $filters   The request, containing all the filters to apply and their respective values
     * @param   Builder   $query     The Eloquent query builder instance
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyDecoratorsFromRequest(Request $filters, Builder $query)
    {
        foreach ($filters->all() as $filterName => $value) {
            $decorator = $this->createFilterDecorator($filterName);

            if ($this->isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }

        return $query;
    }

    /**
     * Return the filepath of the theoretical query filter
     *
     * @param    string   $name   The name of the filter variable
     * @return   string
     */
    protected function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' .
            str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
    }

    /**
     * Does this decorator actually exist?
     *
     * @param    string   $decorator   The class name to check for
     * @return   boolean
     */
    protected function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    /**
     * Limit the return based on input
     *
     * @param    integer   from filters request
     * @return   integer
     */
    protected function getLimit($limit = 5)
    {
        $limit = (integer) $limit;

        if ($limit > 20) {
            $limit = 20;
        }

        return $limit;
    }

    /**
     * Return the results of the selected query, paginated appropriately.
     *
     * @param   Builder   $query   The query
     * @param   integer   $limit   The number of Stories to retrieve at one time
     * @return \Illuminate\Support\Collection
     */
    protected function getResults(Builder $query, $limit)
    {
        return $query->paginate($limit);
    }
}
