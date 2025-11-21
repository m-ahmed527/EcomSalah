<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CategoryController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            'Dashboard' => route('admin.index'),
            'Manage Categories' => route('admin.categories.index'),
        ];
        // dd( Category::with('childrenRecursive')
        //     ->whereNull('parent_id')
        //     ->get());
        $parents = Category::all();
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
                DB::beginTransaction();
                $category = Category::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'parent_id' => $request->parent_id,
                ]);
                DB::commit();
                return successResponse("Category stored successfully");
            } else {
                DB::beginTransaction();
                $category = Category::find($request->id);
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'parent_id' => $request->parent_id,
                ]);
                DB::commit();
                return successResponse("Category updated successfully");
            }

        } catch (Throwable $e) {
            DB::rollBack();
            create_error_log('Storing Category', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();
            $category->delete();
            DB::commit();
            return successResponse("Category deleted successfully");
        } catch (Throwable $e) {
            DB::rollBack();
            create_error_log('Deleting Category', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function destroySelected(Request $request)
    {
        try {
            DB::beginTransaction();
            Category::whereIn('id', $request->ids)->delete();
            DB::commit();
            return successResponse("Categories deleted successfully.");
        } catch (Throwable $e) {
            create_error_log('Category Delete', $e);
            return errorResponse("Something went wrong.");
        }
    }
}
