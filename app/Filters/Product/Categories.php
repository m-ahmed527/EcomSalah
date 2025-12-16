<?php


namespace App\Filters\Product;

use App\Models\Category;
use Closure;

class Categories
{
    public function handle($query, Closure $next)
    {

        $category_id = request('category_id');

        if ($category_id) {

            $category = Category::with('childrenRecursive')->find($category_id);

            if ($category) {

                // sab category IDs nikal lo (self + children + sub-children)
                $categoryIds = collect([$category->id]);
                $getChildrenIds = function ($categories) use (&$getChildrenIds, &$categoryIds) {
                    foreach ($categories as $child) {
                        $categoryIds->push($child->id);

                        if ($child->childrenRecursive->count()) {
                            $getChildrenIds($child->childrenRecursive);
                        }
                    }
                };
                // agar parent hai to children ids bhi add hongi
                if ($category->childrenRecursive->count()) {
                    $getChildrenIds($category->childrenRecursive);
                }

                // products filter
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('category_id', $categoryIds->unique()->values());
                });
            }
        }

        return $next($query);
    }
}
