<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductImportRequest;
use App\Jobs\ProcessProductImport;
use App\Models\Import;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ProductImportController extends Controller
{
    // show upload page
    public function index()
    {
        $breadcrumbs = [
            'Dashboard' => route('admin.index'),
            'Products' => route('admin.products.index'),
            'Product Import' => route('admin.imports.products.index'),
        ];
        return view('screens.admin.products.import', get_defined_vars());
    }

    public function getProductsData(Request $request)
    {
        $imports = Import::select(['*']);
        return datatables()->of($imports)->addIndexColumn()->make(true);
    }
    // upload and queue
    public function store(ProductImportRequest $request)
    {
        try {


            $file = $request->file('file');
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/products/imports'), $name);
            $path = 'uploads/products/imports/' . $name;
            DB::beginTransaction();
            $import = Import::create([
                'filename' => $file->getClientOriginalName(),
                'filepath' => $path,
                'status' => 'queued'
            ]);
            // dd([
            //     'db_path' => $import->filepath,
            //     'public_path' => public_path(),
            //     'final_path' => public_path($import->filepath),
            //     'exists' => file_exists(public_path($import->filepath)),
            // ]);
            DB::commit();
            Log::info('Product import queued.', ['import' => $import]);
            // dispatch job
            ProcessProductImport::dispatch($import->id);

            return response()->json([
                'success' => true,
                'message' => 'Import queued. Processing has started.',
                'import_id' => $import->id
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            create_error_log('Product Import', $e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    // status poll
    public function status(Import $import)
    {
        return response()->json([
            'success' => true,
            'data' => $import->only(['id', 'status', 'processed', 'failed', 'errors_file'])
        ]);
    }

    // serve sample csv
    public function sampleCsv()
    {
        $filename = 'product-import-sample.csv';
        $content = <<<CSV
                    name,sku,base_price,categories,short_description,long_description,stock,is_variable,featured_image,gallery_images,variant_sku,variant_price,variant_stock,variant_attributes
                    T-Shirt,TSH-0005,1000,men,,,50,yes,https://example.com/images/tshirt.jpg,https://example.com/images/t1.jpg|https://example.com/images/t2.jpg,TSH-0005-RED-M,1100,5,"Color=Red,Size=M"
                    T-Shirt,TSH-0005,1000,Men,,,50,yes,https://example.com/images/tshirt.jpg,https://example.com/images/t1.jpg|https://example.com/images/t2.jpg,TSH-0005-BLU-L,1200,8,"Color=Blue,Size=L"
                    Shoes,SHO-0006,3000,woMen,,,20,no,https://example.com/images/shoe.jpg,https://example.com/images/s1.jpg|https://example.com/images/s2.jpg,,,
                    CSV;

        $response = new StreamedResponse(function () use ($content) {
            echo $content;
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    // download errors file
    public function downloadProductFile(Import $import)
    {
        $relative = ltrim($import->filepath ?? '', '/');
        $fullPath = public_path($relative);

        if (empty($relative) || !file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, basename($fullPath));
    }
    public function downloadErrors(Import $import)
    {
        $relative = ltrim($import->errors_file ?? '', '/');
        $fullPath = public_path($relative);

        if (empty($relative) || !file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, basename($fullPath));
    }
    public function destroySelected(Request $request)
    {
        try {
            DB::beginTransaction();
            $imports = Import::whereIn('id', $request->ids)->get();
            foreach ($imports as $import) {
                $this->unlinkAllFiles($import);
            }
            Import::whereIn('id', $request->ids)->delete();
            DB::commit();
            return successResponse("Imports deleted successfully.");
        } catch (Throwable $e) {
            DB::rollBack();
            create_error_log('Imports Delete', $e);
            return errorResponse("Something went wrong.");
        }
    }

    private function unlinkAllFiles($import)
    {
        $importPath = public_path($import->filepath);
        $errorsPath = public_path($import->errors_file);
        if (File::exists($importPath)) {
            File::delete($importPath);
        }
        if (File::exists($errorsPath)) {
            File::delete($errorsPath);
        }
    }
}
