<?php

namespace App\Filters\Product;

use Closure;

class SortByPrice
{
    public function handle($query, Closure $next)
    {
        if (in_array(request('sort'), ['price_low_high', 'price_high_low'])) {

            $direction = request('sort') == 'price_low_high' ? 'asc' : 'desc';

            return $next($query->orderBy('effective_price', $direction));
        }

        return $next($query);
    }
}
