<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            'Dashboard' => route('admin.index'),
            'Products' => route('admin.products.index'),
        ];
        return view('screens.admin.products.index', get_defined_vars());
    }
    public function getProductsData(Request $request)
    {
        $products = Product::select(['*']);
        return datatables()
            ->of($products)
            ->addIndexColumn()
            ->make(true);
    }

    public function show(Product $product)
    {
        try {
            $product->load('variants.values.attribute', 'images', 'categories');
            return successResponse("Product found successfully", $product);
        } catch (Throwable $e) {
            create_error_log('Getting Product', $e);
            return errorResponse("Something went wrong.");
        }
    }
    public function create()
    {
        $breadcrumbs = [
            'Dashboard' => route('admin.index'),
            'Products' => route('admin.products.index'),
            'Create Product' => '#',
        ];
        $attributes = Attribute::with('values')->get();
        $categories = Category::all();
        return view('screens.admin.products.create', get_defined_vars());
    }

    public function store(CreateProductRequest $request)
    {

        try {
            // dd($request->sanitized());
            DB::beginTransaction();
            $product = Product::create($request->sanitized());
            $product->categories()->attach([$request->category_id]);
            $images = $this->productImages($request);
            if (!empty($images)) {
                $product->images()->createMany($images);
            }

            // ✅ Variants
            if ($request->has('variants')) {
                // ✅ Variants handle (refactored)
                $this->createProductVariants($product, $request->variants ?? []);

            }
            DB::commit();
            return successResponse("Product created successfully.");
        } catch (Throwable $e) {
            DB::rollback();
            create_error_log('Product Create', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function edit(Product $product)
    {
        $breadcrumbs = [
            'Dashboard' => route('admin.index'),
            'Products' => route('admin.products.index'),
            'Edit Product' => '#',
        ];
        $product->load('variants.values.attribute', 'images', 'categories');
        $attributes = Attribute::with('values')->get();
        $categories = Category::all();
        return view('screens.admin.products.edit', get_defined_vars());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            // 1️⃣ Update product fields
            $product->update($request->sanitized());
            $product->categories()->sync([$request->category_id]);
            // 2️⃣ Update gallery images (optional new uploads)
            if ($request->hasFile('gallery_images')) {
                $images = $this->productImages($request);
                if (!empty($images)) {
                    // $product->images()->delete(); // Uncomment if you want to replace old
                    $product->images()->createMany($images);
                }
            }

            // 3️⃣ Update variants
            if ($request->has('variants')) {
                // 3️⃣ Handle variants (optimized batch)
                $this->syncProductVariants($product, $request->variants ?? []);

            }

            DB::commit();
            return successResponse("Product updated successfully.");
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            create_error_log('Product Update', $e);
            return errorResponse("Something went wrong.");
        }
    }


    public function destroy(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $this->unlinkAllImages($product);
            $product->delete();
            DB::commit();
            return successResponse("Product deleted successfully.");
        } catch (Throwable $e) {
            DB::rollBack();
            create_error_log('Product Delete', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function destroySelected(Request $request){
        try {
            DB::beginTransaction();
            $products = Product::whereIn('id', $request->ids)->get();
            foreach ($products as $product) {
                $this->unlinkAllImages($product);
            }
            Product::whereIn('id', $request->ids)->delete();
            DB::commit();
            return successResponse("Products deleted successfully.");
        } catch (Throwable $e) {
            DB::rollBack();
            create_error_log('Product Delete', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function destroyImage(ProductImage $image)
    {
        try {
            DB::beginTransaction();
            $this->unlinkImage($image->image);
            $image->delete();
            DB::commit();
            return successResponse("Image deleted successfully.");
        } catch (Throwable $e) {
            DB::rollBack();
            create_error_log('Product Delete', $e);
            return errorResponse("Something went wrong.");
        }
    }

    private function productImages(Request $request, $product = null)
    {
        if ($request->hasFile('gallery_images')) {
            $images = $request->file('gallery_images');
            $imageNames = [];
            foreach ($images as $image) {
                $imageName = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products/gallery'), $imageName);
                $imageNames[] = [
                    'image' => asset('uploads/products/gallery/' . $imageName),
                ];
            }
            return $imageNames;
        }
        return [];
    }

    private function unlinkAllImages($product)
    {
        $images = $product->images;
        $this->unlinkImage($product->featured_image);
        foreach ($images as $image) {
            $filePath = public_path(parse_url($image->image, PHP_URL_PATH));
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
    }

    private function unlinkImage($image)
    {
        $imagePath = public_path(parse_url($image, PHP_URL_PATH));

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
    }



    private function createProductVariants(Product $product, array $variants): void
    {
        if (empty($variants)) {
            return;
        }

        $variantData = [];
        $variantValueRelations = [];
        $now = now();

        foreach ($variants as $variant) {
            $attrIds = $variant['attribute_value_ids'] ?? [];

            // skip invalid data
            if (!is_array($attrIds) || empty($attrIds) || in_array(null, $attrIds, true)) {
                continue;
            }

            $variantData[] = [
                'product_id' => $product->id,
                'sku' => $variant['sku'] ?? null,
                'price' => $variant['price'] ?? 0,
                'stock' => $variant['stock'] ?? 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // temporarily store attribute ids (we’ll map them later)
            $variantValueRelations[] = $attrIds;
        }

        if (empty($variantData)) {
            return;
        }

        // ✅ Batch insert variants
        ProductVariant::insert($variantData);

        // ✅ Get inserted variants with correct IDs
        $insertedVariants = ProductVariant::where('product_id', $product->id)
            ->orderBy('id', 'desc')
            ->take(count($variantData))
            ->get()
            ->reverse() // because last inserted first comes first
            ->values();

        // ✅ Prepare pivot (variant_value) data
        $pivotData = [];
        foreach ($insertedVariants as $index => $variantModel) {
            foreach ($variantValueRelations[$index] as $valueId) {
                $pivotData[] = [
                    'product_variant_id' => $variantModel->id,
                    'attribute_value_id' => $valueId,
                ];
            }
        }

        // ✅ Batch insert into pivot table (assuming table name `product_variant_values`)
        DB::table('product_variant_values')->insert($pivotData);
    }

    /**
     * Sync product variants in optimized batch way
     */
    private function syncProductVariants(Product $product, array $variants): void
    {
        $now = now();

        // existing variants
        $existing = $product->variants()->pluck('id')->toArray();

        $toInsert = [];
        $toUpdate = [];
        $updateValueRelations = []; // existing variants ke attribute IDs
        $insertValueRelations = []; // new variants ke attribute IDs
        $submittedIds = [];

        foreach ($variants as $variant) {
            $attrIds = $variant['attribute_value_ids'] ?? [];

            // skip invalid variant
            if (!is_array($attrIds) || empty($attrIds) || in_array(null, $attrIds, true)) {
                continue;
            }

            if (!empty($variant['id']) && in_array($variant['id'], $existing)) {
                // ✅ existing variant (update)
                $toUpdate[] = [
                    'id' => $variant['id'],
                    'sku' => $variant['sku'] ?? null,
                    'price' => $variant['price'] ?? 0,
                    'stock' => $variant['stock'] ?? 1,
                    'updated_at' => $now,
                ];
                $updateValueRelations[$variant['id']] = $attrIds;
                $submittedIds[] = $variant['id'];
            } else {
                // ✅ new variant (insert later)
                $toInsert[] = [
                    'product_id' => $product->id,
                    'sku' => $variant['sku'] ?? null,
                    'price' => $variant['price'] ?? 0,
                    'stock' => $variant['stock'] ?? 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $insertValueRelations[] = $attrIds; // index-based
            }
        }

        // ✅ Batch update existing variants
        if (!empty($toUpdate)) {
            foreach ($toUpdate as $data) {
                ProductVariant::where('id', $data['id'])->update([
                    'sku' => $data['sku'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'updated_at' => $data['updated_at'],
                ]);
            }

            // sync their attribute values
            foreach ($updateValueRelations as $variantId => $attrIds) {
                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    $variant->values()->sync($attrIds);
                }
            }
        }

        // ✅ Batch insert new variants
        if (!empty($toInsert)) {
            ProductVariant::insert($toInsert);

            // get newly inserted variants
            $inserted = ProductVariant::where('product_id', $product->id)
                ->orderBy('id', 'desc')
                ->take(count($toInsert))
                ->get()
                ->reverse()
                ->values();

            // prepare pivot data
            $pivotData = [];
            foreach ($inserted as $index => $variantModel) {
                if (!isset($insertValueRelations[$index]))
                    continue; // 🔧 avoid undefined index
                foreach ($insertValueRelations[$index] as $valueId) {
                    $pivotData[] = [
                        'product_variant_id' => $variantModel->id,
                        'attribute_value_id' => $valueId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                $submittedIds[] = $variantModel->id;
            }

            // batch insert pivot
            if (!empty($pivotData)) {
                DB::table('product_variant_values')->insert($pivotData);
            }
        }

        // ✅ Delete removed variants
        $toDelete = array_diff($existing, $submittedIds);
        if (!empty($toDelete)) {
            ProductVariant::whereIn('id', $toDelete)->delete();
        }
    }


}

/**
 * Handle creation of product variants
 */
// private function createProductVariants(Product $product, array $variants): void
// {
//     foreach ($variants as $variant) {
//         $attrIds = $variant['attribute_value_ids'] ?? [];

//         // Skip invalid attribute arrays
//         if (!is_array($attrIds) || empty($attrIds) || in_array(null, $attrIds, true)) {
//             continue;
//         }

//         $productVariant = $product->variants()->create([
//             'sku' => $variant['sku'] ?? null,
//             'price' => $variant['price'] ?? 0,
//             'stock' => $variant['stock'] ?? 1,
//         ]);

//         $productVariant->values()->attach($attrIds);
//     }
// }


// Create ke liye

// foreach ($request->variants as $variant) {
//     $attrIds = $variant['attribute_value_ids'] ?? [];

//     // Skip if it's not an array, empty, or contains any null value
//     if (!is_array($attrIds) || empty($attrIds) || in_array(null, $attrIds, true)) {
//         continue;
//     }

//     $productVariant = ProductVariant::create([
//         'product_id' => $product->id,
//         'sku' => $variant['sku'] ?? null,
//         'price' => $variant['price'] ?? 0,
//         'stock' => $variant['stock'] ?? 1,
//     ]);

//     $productVariant->values()->attach($attrIds);
// }






// Update k liye

// Prepare variant data
// $existingVariantIds = $product->variants->pluck('id')->toArray();
// $submittedVariantIds = [];
// foreach ($request->variants as $variantData) {
//     $attrIds = $variantData['attribute_value_ids'] ?? [];

//     // Skip if it's not an array, empty, or contains any null value
//     if (!is_array($attrIds) || empty($attrIds) || in_array(null, $attrIds, true)) {
//         continue;
//     }
//     if (isset($variantData['id'])) {
//         // Update existing variant
//         $variant = ProductVariant::find($variantData['id']);
//         $variant->update([
//             'sku' => $variantData['sku'] ?? null,
//             'price' => $variantData['price'] ?? 0,
//             'stock' => $variantData['stock'] ?? 1,
//         ]);
//         $variant->values()->sync($variantData['attribute_value_ids']);
//         $submittedVariantIds[] = $variant->id;
//     } else {
//         // Create new variant
//         $newVariant = $product->variants()->create([
//             'sku' => $variantData['sku'] ?? null,
//             'price' => $variantData['price'] ?? 0,
//             'stock' => $variantData['stock'] ?? 1,
//         ]);
//         $newVariant->values()->syncWithoutDetaching($variantData['attribute_value_ids']);
//         $submittedVariantIds[] = $newVariant->id;
//     }
// }

// // Delete removed variants
// $toDelete = array_diff($existingVariantIds, $submittedVariantIds);
// ProductVariant::whereIn('id', $toDelete)->delete();
