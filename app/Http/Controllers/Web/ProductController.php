<?php

namespace App\Http\Controllers\Web;

use App\Filters\Product\PriceRange;
use App\Filters\Product\SortByName;
use App\Filters\Product\SortByPrice;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            'Home' => route('web.index'),
            'Products' => route('web.product.index'),
        ];
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $products = Product::filter([
            SortByName::class,
            SortByPrice::class,
            PriceRange::class
        ])->paginate(6);
        if (request()->ajax()) {
            try {
                $html = view('screens.web.product.partials.list', get_defined_vars())->render();
                $pagination = view('screens.web.product.partials.pagination', get_defined_vars())->render();
                $showingResults = view('screens.web.product.partials.showing-results', get_defined_vars())->render();
                return successResponse('Products fetched successfully', [
                    'html' => $html,
                    'pagination' => $pagination,
                    'showing_results' => $showingResults
                ]);
            } catch (Throwable $e) {
                create_error_log('Product Index Ajax', $e);
                return errorResponse('Failed to fetch products', $e->getMessage());
            }
        } else {
            return view('screens.web.product.index', get_defined_vars());
        }
    }

    public function show(Product $product)
    {

        $breadcrumbs = [
            'Home' => route('web.index'),
            'Products' => route('web.product.index'),
            'Product Details' => '#',
        ];
        $product->load('variants.values.attribute');
        // Filter only attributes and values used in this product's variants
        $usedAttributes = collect();
        $usedValues = collect();

        foreach ($product->variants as $variant) {
            foreach ($variant->values as $value) {
                $usedValues->push($value);
                $usedAttributes->push($value->attribute);
            }
        }
        // dd($product->variants);
        // Unique attributes and values only
        $attributes = $usedAttributes->unique('id')->map(function ($attribute) use ($usedValues) {
            $attribute->values = $usedValues->where('attribute_id', $attribute->id)->unique('id')->values();
            return $attribute;
        });

        $variantMap = [];
        foreach ($product->variants as $variant) {
            $combo = [];
            foreach ($variant->values as $value) {
                // dd($value);
                $combo[$value->attribute->id] = $value->id;
            }
            $variantMap[] = $combo;
        }
        $relatedProducts = Product::where('id', '!=', $product->id)->inRandomOrder()->take(4)->get();
        return view('screens.web.product.show', get_defined_vars());
    }
    public function getVariant(Request $request)
    {
        try {

            $valueIds = $request->input('attribute_value_ids');
            $variant = ProductVariant::where('product_id', $request->product_id)
                ->whereHas('values', function ($q) use ($valueIds) {
                    $q->whereIn('attribute_value_id', $valueIds);
                }, '=', count($valueIds))
                ->with('values')
                ->first();
            if ($variant) {
                return successResponse('Variant fetched successfully', [
                    // 'price' => number_format($variant->price + $variant->product->base_price, 2),
                    'price' => $variant->price,
                    'stock' => $variant->stock,
                    'variant_id' => $variant->id,
                ]);
            } else {
                return errorResponse('This is combination is out of stock, Please select another', 404);
            }
        } catch (Throwable $e) {
            create_error_log('Get Variant Ajax', $e);
            return errorResponse('Failed to fetch variant', $e->getMessage());
        }
    }

    public function details(Product $product)
    {
        if (!request()->ajax()) {
            return errorResponse('Invalid request', 'This endpoint only accepts AJAX requests.');
        } else {
            try {
                $html = view('screens.web.product.partials.modal-content', get_defined_vars())->render();
                return successResponse('Product details fetched successfully', [
                    'html' => $html,
                ]);
            } catch (Throwable $e) {
                create_error_log('Product Details Ajax', $e);
                return errorResponse('Failed to fetch product details', $e->getMessage());
            }
        }
    }
}
