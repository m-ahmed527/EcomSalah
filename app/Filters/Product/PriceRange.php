<?php


namespace App\Filters\Product;

use Closure;

class PriceRange
{
    public function handle($query, Closure $next)
    {
        $min = request('price_min');
        $max = request('price_max');

        if ($min !== null && $max !== null) {
            // $query->whereHas('variants', function ($q) use ($min, $max) {
            //     $q->whereBetween('effective_price', [$min, $max]);
            // });
            $query->whereBetween('effective_price', [$min, $max]);
        }
        // dd($query->get());
        return $next($query);
    }
}
