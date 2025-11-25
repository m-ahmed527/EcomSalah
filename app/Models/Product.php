<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
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
}
