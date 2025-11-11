<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function create()
    {
        $attributes = Attribute::with('values')->get();
        return view('screens.admin.products.create', get_defined_vars());
    }
    public function store(CreateProductRequest $request)
    {

        try {
            DB::beginTransaction();
            $product = Product::create($request->sanitized());
            $images = $this->productImages($request);
            if (!empty($images)) {
                $product->images()->createMany($images);
            }

            // ✅ Variants SKU generation
            if ($request->has('variants')) {
                $variants = $this->prepareVariants($request);
                $product->variants()->createMany($variants);
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
        $attributes = Attribute::with('values')->get();

        // extract used attribute values from variants
        $usedAttributeValues = [];
        foreach ($product->variants as $variant) {
            $parts = explode(' / ', $variant->variant_name); // e.g. "Red / M"
            foreach ($parts as $part) {
                $usedAttributeValues[] = trim($part);
            }
        }
        $product->load('images', 'variants');
        return view('screens.admin.products.edit', get_defined_vars());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            // 1️⃣ Product main fields update
            $product->update($request->sanitized());

            // 2️⃣ Gallery images handle
            if ($request->hasFile('gallery_images')) {
                $newImages = $this->productImages($request);

                if (!empty($newImages)) {
                    // (optional) Purani images delete karni ho to uncomment karo:
                    // $product->images()->delete();

                    $product->images()->createMany($newImages);
                }
            }

            // 3️⃣ Variants handle
            if ($request->has('variants')) {
                $variants = $this->prepareVariants($request);

                // existing variant IDs
                $existingIds = $product->variants()->pluck('id')->toArray();
                $incomingIds = collect($request->variants)
                    ->pluck('id')
                    ->filter()
                    ->toArray();

                // 🔹 Delete variants jo ab request me nahi hain
                $toDelete = array_diff($existingIds, $incomingIds);
                if (!empty($toDelete)) {
                    $product->variants()->whereIn('id', $toDelete)->delete();
                }

                // 🔹 Update ya Create variants
                foreach ($request->variants as $variant) {
                    $variantData = [
                        'variant_name' => $variant['name'] ?? null,
                        'price' => $variant['price'] ?? 0,
                        'stock' => $variant['stock'] ?? 1,
                        'sku' => $variant['sku'] ?? null,
                    ];

                    if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $image = $variant['image'];
                        $imageName = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
                        $image->move(public_path('uploads/products/variants'), $imageName);
                        $variantData['image'] = asset('uploads/products/variants/' . $imageName);
                    }

                    if (isset($variant['id'])) {
                        // update existing
                        $product->variants()->where('id', $variant['id'])->update($variantData);
                    } else {
                        // create new
                        $product->variants()->create($variantData);
                    }
                }
            }

            DB::commit();
            return successResponse('Product updated successfully.');
        } catch (Throwable $e) {
            DB::rollback();
            create_error_log('Product Update', $e);
            return errorResponse('Something went wrong.');
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

    private function prepareVariants(Request $request)
    {
        $variants = [];

        foreach ($request->variants as $variant) {
            $variantData = [
                'variant_name' => $variant['name'] ?? null,
                'price' => $variant['price'] ?? 0,
                'stock' => $variant['stock'] ?? 1,
                'sku' => $variant['sku'] ?? null,
            ];

            // 👇 Check if image exists and is an uploaded file
            if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                $image = $variant['image'];
                $imageName = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products/variants'), $imageName);
                $variantData['image'] = asset('uploads/products/variants/' . $imageName);
            }

            $variants[] = $variantData;
        }

        return $variants;
    }


}
