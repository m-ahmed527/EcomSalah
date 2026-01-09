<?php


namespace App\Filters\Product;

use App\Models\Category;
use Closure;

class TagsFilter
{
    public function handle($query, Closure $next)
    {

        $tags = request('tags');
        if ($tags && is_array($tags) && count($tags) > 0) {
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('tag_id', $tags);
            });
        }

        return $next($query);
    }
}
