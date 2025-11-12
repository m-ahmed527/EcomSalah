<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $guarded = ['id'];
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // public function variants()
    // {
    //     return $this->belongsToMany(ProductVariant::class, 'product_variant_values')->withTimestamps();
    // }
}
