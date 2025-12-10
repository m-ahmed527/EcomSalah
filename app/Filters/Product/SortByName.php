<?php

namespace App\Filters\Product;

use Closure;

class SortByName
{
    public function handle($query, Closure $next)
    {
        if (request('sort') === 'name_asc') {
            $query->orderBy('name', 'asc');
        }

        if (request('sort') === 'name_desc') {
            $query->orderBy('name', 'desc');
        }

        return $next($query);
    }
}
