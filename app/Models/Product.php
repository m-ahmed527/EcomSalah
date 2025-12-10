<?php

namespace App\Models;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use Filter;
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
   
    public static function globalMinPrice()
    {
        $minProduct = Product::min('effective_price');
        $minVariant = ProductVariant::min('effective_price');
        $min = $minVariant > $minProduct ? $minVariant : $minProduct;
        return $min ?? Product::min('base_price');
    }

    public static function globalMaxPrice()
    {
        $maxProduct = Product::max('effective_price');
        $maxVariant = ProductVariant::max('effective_price');
        $max = $maxVariant > $maxProduct ? $maxVariant : $maxProduct;
        return $max ?? Product::max('base_price');
    }

    public function priceRange()
    {
        $prices = $this->variants()->pluck('price')->filter();


        $prices = $prices->map(function ($p) {
            return (float) $p + (float) $this->base_price;
        })->sort()->values();

        if ($prices->isEmpty()) {
            return (float) $this->base_price;
        }
        return $prices->count() > 1 ?
            number_format($prices->first(), 2) . ' - ' . number_format($prices->last(), 2) :
            number_format($this->base_price, 2);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories')->withTimestamps();
    }

    public function wishlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }
}
