<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class CategoryController extends Controller
{
    public function index()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('screens.admin.categories.index', get_defined_vars());
    }
    public function getCategoriesData()
    {
        $categories = Category::with('parent:id,name')
            ->select('id', 'name', 'parent_id');

        return datatables()->of($categories)
            ->addIndexColumn()
            ->addColumn('parent_name', function ($row) {
                return $row->parent?->name ?? '—';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            if (!$request->id || $request->id == null || $request->id == 'null') {
                $category = Category::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'parent_id' => $request->parent_id,
                ]);
                return successResponse("Category stored successfully");
            } else {
                $category = Category::find($request->id);
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'parent_id' => $request->parent_id,
                ]);
                return successResponse("Category updated successfully");
            }

        } catch (Throwable $e) {
            create_error_log('Storing Category', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return successResponse("Category deleted successfully");
        } catch (Throwable $e) {
            create_error_log('Deleting Category', $e);
            return errorResponse("Something went wrong.");
        }
    }
}
