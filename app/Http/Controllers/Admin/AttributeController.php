<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class AttributeController extends Controller
{
    public function index()
    {
        return view('screens.admin.attributes.index');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255|',
            'values' => 'required|array',
            'values.*' => 'required|string|max:255'
        ]);
        try {
            if (!$request->has('id') || $request->id == null || $request->id == 'null') {


                $attribute = Attribute::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name)
                ]);

                if ($request->values) {
                    $values = $this->prepareValues($request->values);
                    $attribute->values()->createMany($values);
                }

                return successResponse("Attribute stored successfully");
            } else {
                $attribute = Attribute::find($request->id);
                $attribute->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name)
                ]);
                $attribute->values()->delete();
                if ($request->values) {
                    $values = $this->prepareValues($request->values);
                    $attribute->values()->createMany($values);
                }
                return successResponse("Attribute updated successfully");
            }
        } catch (Throwable $e) {
            create_error_log('Storing Attribute', $e);
            return errorResponse("Something went wrong.");
        }
    }
    private function prepareValues($values)
    {
        $data = [];
        foreach ($values as $value) {
            $data[] = [
                'value' => $value
            ];
        }
        return $data;
    }
}
