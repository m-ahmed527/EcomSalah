<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
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
            $product->load('variants.values.attribute', 'images');
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
        return view('screens.admin.products.create', get_defined_vars());
    }

    public function store(CreateProductRequest $request)
    {

        try {
            // dd($request->sanitized());
            DB::beginTransaction();
            $product = Product::create($request->sanitized());
            $images = $this->productImages($request);
            if (!empty($images)) {
                $product->images()->createMany($images);
            }

            // ✅ Variants SKU generation
            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    $attrIds = $variant['attribute_value_ids'] ?? [];

                    // Skip if it's not an array, empty, or contains any null value
                    if (!is_array($attrIds) || empty($attrIds) || in_array(null, $attrIds, true)) {
                        continue;
                    }

                    $productVariant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $variant['sku'] ?? null,
                        'price' => $variant['price'] ?? 0,
                        'stock' => $variant['stock'] ?? 1,
                    ]);

                    $productVariant->values()->attach($attrIds);
                }
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
        $product->load('variants.values.attribute', 'images');
        $attributes = Attribute::with('values')->get();
        return view('screens.admin.products.edit', get_defined_vars());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            // 1️⃣ Update product fields
            $product->update($request->sanitized());
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
                // Prepare variant data
                $existingVariantIds = $product->variants->pluck('id')->toArray();
                $submittedVariantIds = [];
                foreach ($request->variants as $variantData) {
                    $attrIds = $variantData['attribute_value_ids'] ?? [];

                    // Skip if it's not an array, empty, or contains any null value
                    if (!is_array($attrIds) || empty($attrIds) || in_array(null, $attrIds, true)) {
                        continue;
                    }
                    if (isset($variantData['id'])) {
                        // Update existing variant
                        $variant = ProductVariant::find($variantData['id']);
                        $variant->update([
                            'sku' => $variantData['sku'] ?? null,
                            'price' => $variantData['price'] ?? 0,
                            'stock' => $variantData['stock'] ?? 1,
                        ]);
                        $variant->values()->sync($variantData['attribute_value_ids']);
                        $submittedVariantIds[] = $variant->id;
                    } else {
                        // Create new variant
                        $newVariant = $product->variants()->create([
                            'sku' => $variantData['sku'] ?? null,
                            'price' => $variantData['price'] ?? 0,
                            'stock' => $variantData['stock'] ?? 1,
                        ]);
                        $newVariant->values()->syncWithoutDetaching($variantData['attribute_value_ids']);
                        $submittedVariantIds[] = $newVariant->id;
                    }
                }

                // Delete removed variants
                $toDelete = array_diff($existingVariantIds, $submittedVariantIds);
                ProductVariant::whereIn('id', $toDelete)->delete();
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


    public function destroy(Product $product)
    {
        try {
            dd($product);
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            return successResponse("Product deleted successfully.");
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




}
// private function prepareVariants(Request $request)
// {
//     $variants = [];

//     foreach ($request->variants as $variant) {

//         $variantData = [
//             // 'variant_name' => $variant['name'] ?? null,
//             'price' => $variant['price'] ?? 0,
//             'stock' => $variant['stock'] ?? 1,
//             'sku' => $variant['sku'] ?? null,
//         ];

//         // 👇 Check if image exists and is an uploaded file
//         if (isset($variant['image']) && $variant['image'] instanceof UploadedFile) {
//             $image = $variant['image'];
//             $imageName = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
//             $image->move(public_path('uploads/products/variants'), $imageName);
//             $variantData['image'] = asset('uploads/products/variants/' . $imageName);
//         }

//         $variants[] = $variantData;
//     }

//     return $variants;
// }
// public function update(UpdateProductRequest $request, Product $product)
// {
//     try {
//         DB::beginTransaction();

//         // 1️⃣ Product main fields update
//         $product->update($request->sanitized());

//         // 2️⃣ Gallery images handle
//         if ($request->hasFile('gallery_images')) {
//             $newImages = $this->productImages($request);

//             if (!empty($newImages)) {
//                 // (optional) Purani images delete karni ho to uncomment karo:
//                 // $product->images()->delete();

//                 $product->images()->createMany($newImages);
//             }
//         }

//         // 3️⃣ Variants handle
//         if ($request->has('variants')) {
//             $variants = $this->prepareVariants($request);

//             // existing variant IDs
//             $existingIds = $product->variants()->pluck('id')->toArray();
//             $incomingIds = collect($request->variants)
//                 ->pluck('id')
//                 ->filter()
//                 ->toArray();

//             // 🔹 Delete variants jo ab request me nahi hain
//             $toDelete = array_diff($existingIds, $incomingIds);
//             if (!empty($toDelete)) {
//                 $product->variants()->whereIn('id', $toDelete)->delete();
//             }

//             // 🔹 Update ya Create variants
//             foreach ($request->variants as $variant) {
//                 $variantData = [
//                     'variant_name' => $variant['name'] ?? null,
//                     'price' => $variant['price'] ?? 0,
//                     'stock' => $variant['stock'] ?? 1,
//                     'sku' => $variant['sku'] ?? null,
//                 ];

//                 if (isset($variant['image']) && $variant['image'] instanceof UploadedFile) {
//                     $image = $variant['image'];
//                     $imageName = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
//                     $image->move(public_path('uploads/products/variants'), $imageName);
//                     $variantData['image'] = asset('uploads/products/variants/' . $imageName);
//                 }

//                 if (isset($variant['id'])) {
//                     // update existing
//                     $product->variants()->where('id', $variant['id'])->update($variantData);
//                 } else {
//                     // create new
//                     $product->variants()->create($variantData);
//                 }
//             }
//         }

//         DB::commit();
//         return successResponse('Product updated successfully.');
//     } catch (Throwable $e) {
//         DB::rollback();
//         create_error_log('Product Update', $e);
//         return errorResponse('Something went wrong.');
//     }
// }

// public function update(UpdateProductRequest $request, Product $product)
// {
//     try {
//         DB::beginTransaction();

//         // 1️⃣ Update product fields
//         $product->update($request->sanitized());
//         // 2️⃣ Update gallery images (optional new uploads)
//         if ($request->hasFile('gallery_images')) {
//             $images = $this->productImages($request);
//             if (!empty($images)) {
//                 // $product->images()->delete(); // Uncomment if you want to replace old
//                 $product->images()->createMany($images);
//             }
//         }

//         // 3️⃣ Update variants
//         if ($request->has('variants')) {
//             // Prepare variant data
//             $variants = $this->prepareVariants($request);
//             // Existing + incoming variant IDs
//             $existing = $product->variants()->pluck('id')->toArray();
//             $incoming = collect($request->variants)->pluck('id')->filter()->toArray();

//             // Delete removed variants
//             $toDelete = array_diff($existing, $incoming);
//             // dd($variants,$existing,$incoming,$toDelete,$request->variants);
//             if ($toDelete) {
//                 $product->variants()->whereIn('id', $toDelete)->delete();
//             }

//             // Create / Update variants
//             foreach ($request->variants as $i => $variant) {
//                 $data = $variants[$i];

//                 if (!empty($variant['id'])) {
//                     $product->variants()->where('id', $variant['id'])->update($data);
//                 } else {
//                     $product->variants()->create($data);
//                 }
//             }
//         }

//         DB::commit();
//         return successResponse("Product updated successfully.");
//     } catch (Throwable $e) {
//         DB::rollBack();
//         dd($e->getMessage());
//         create_error_log('Product Update', $e);
//         return errorResponse("Something went wrong.");
//     }
// }
