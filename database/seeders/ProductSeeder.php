<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Product 1',
                'slug' => 'product-1',
                'short_description' => 'Short description for Product 1',
                'long_description' => 'Long description for Product 1',
                'base_price' => 10.00,
                'stock' => 10,
                'sku' => 'PRO'.'-' . str_pad(1, 4, '0', STR_PAD_LEFT),
                'featured_image' => asset('assets/web/images/shop/products/product-1.jpg'),
                'has_variants' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 2',
                'slug' => 'product-2',
                'short_description' => 'Short description for Product 2',
                'long_description' => 'Long description for Product 2',
                'base_price' => 15.50,
                'stock' => 20,
                'sku' => 'PRO'.'-' . str_pad(2, 4, '0', STR_PAD_LEFT),
                'featured_image' => asset('assets/web/images/shop/products/product-2.jpg'),
                'has_variants' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 3',
                'slug' => 'product-3',
                'short_description' => 'Short description for Product 3',
                'long_description' => 'Long description for Product 3',
                'base_price' => 20.00,
                'stock' => 15,
                'sku' => 'PRO'.'-' . str_pad(3, 4, '0', STR_PAD_LEFT),
                'featured_image' => asset('assets/web/images/shop/products/product-3.jpg'),
                'has_variants' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 4',
                'slug' => 'product-4',
                'short_description' => 'Short description for Product 4',
                'long_description' => 'Long description for Product 4',
                'base_price' => 25.00,
                'stock' => 5,
                'sku' => 'PRO'.'-' . str_pad(4, 4, '0', STR_PAD_LEFT),
                'featured_image' => asset('assets/web/images/shop/products/product-4.jpg'),
                'has_variants' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 5',
                'slug' => 'product-5',
                'short_description' => 'Short description for Product 5',
                'long_description' => 'Long description for Product 5',
                'base_price' => 30.00,
                'stock' => 8,
                'sku' => 'PRO'.'-' . str_pad(5, 4, '0', STR_PAD_LEFT),
                'featured_image' => asset('assets/web/images/shop/products/product-5.jpg'),
                'has_variants' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];



        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        ProductVariant::truncate();
        DB::table('product_variant_values')->truncate();
        DB::table('product_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Product::insertOrIgnore($products);
        DB::table('product_categories')->insertOrIgnore([
            ['product_id' => 1, 'category_id' => 2],
            ['product_id' => 2, 'category_id' => 2],
            ['product_id' => 3, 'category_id' => 3],
            ['product_id' => 4, 'category_id' => 2],
            ['product_id' => 5, 'category_id' => 3],
        ]);




        // Attribute Values (already seeded)
        // Predefined attribute values
        $sizes = [1, 2, 3]; // S, M, L
        $colors = [4, 5];    // Blue, Red

        $allProducts = Product::all();

        foreach ($allProducts as $product) {

            foreach ($sizes as $sizeId) {
                foreach ($colors as $colorId) {

                    // get attribute value text (example: RED / M)
                    $sizeText = AttributeValue::find($sizeId)->value;
                    $colorText = AttributeValue::find($colorId)->value;

                    // SKU format: TSH-0001-RED-M
                    $variantSku = $product->sku . '-' . strtoupper($colorText) . '-' . strtoupper($sizeText);

                    $variant = $product->variants()->create([
                        'variant_name' => $variantSku,
                        'sku' => $variantSku,
                        'price' => $product->base_price + rand(1, 5),
                        'stock' => rand(5, 20),
                    ]);

                    // Attach attributes to variant
                    $variant->values()->attach([$sizeId, $colorId]);
                }
            }
        }
    }
}
