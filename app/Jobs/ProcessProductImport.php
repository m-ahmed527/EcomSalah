<?php

namespace App\Jobs;

use App\Models\Import;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $importId;

    public function __construct($importId)
    {
        $this->importId = $importId;
    }

    public function handle()
    {
        $import = Import::find($this->importId);
        \Log::info('Processing import');
        if (!$import)
            return;

        $import->update(['status' => 'processing', 'processed' => 0, 'failed' => 0]);
        $errors = [];
        $processed = 0;
        $failed = 0;

        $path = public_path($import->filepath);
        \Log::info('Processing import', ['path' => $path]);
        if (!file_exists($path)) {
            $import->update(['status' => 'failed', 'notes' => 'File not found']);
            return;
        }

        // open csv
        if (($handle = fopen($path, 'r')) !== false) {
            $header = null;
            $rowNumber = 1;
            while (($row = fgetcsv($handle)) !== false) {
                // skip empty lines
                if ($row === [null] || count($row) === 0) {
                    $rowNumber++;
                    continue;
                }

                if (!$header) {
                    $header = array_map(function ($h) {
                        return trim($h);
                    }, $row);
                    $rowNumber++;
                    continue;
                }

                $data = array_combine($header, array_pad($row, count($header), null));
                $rowNumber++;

                // basic validation per row
                try {
                    DB::beginTransaction();

                    // minimal required columns check
                    if (empty($data['name']) || empty($data['sku'])) {
                        throw new \Exception('Missing required product name or sku (columns name, sku)');
                    }
                    Log::info('Processing Data', ['data' => $data]);
                    // find or create product
                    $product = Product::firstOrCreate(
                        ['sku' => trim($data['sku'])],
                        [
                            'name' => $data['name'],
                            'slug' => Str::slug($data['name']),
                            'base_price' => is_numeric($data['base_price']) ? $data['base_price'] : 0,
                            'stock' => is_numeric($data['stock']) ? intval($data['stock']) : 0,
                            'short_description' => $data['short_description'] ? trim($data['short_description']) : null,
                            'long_description' => $data['long_description'] ? trim($data['long_description']) : null,
                            'has_variants' => (strtolower(trim($data['is_variable'] ?? 'no')) === 'yes') ? 1 : 0,
                            // featured_image store as string (you may implement download logic)
                            'featured_image' => $data['featured_image'] ? trim($data['featured_image']) : null,
                        ]
                    );

                    if (!empty($data['categories'])) {
                        // "Mobile|Accessories|ANDROID Phone" jesa input aayega
                        $rawNames = explode('|', $data['categories']);

                        // trimming + lowercase version for matching
                        $cleanNames = array_map(function ($n) {
                            return trim($n);
                        }, $rawNames);

                        $categoryIds = [];

                        foreach ($cleanNames as $name) {

                            // CASE-INSENSITIVE MATCH
                            $category = Category::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();

                            if (!$category) {
                                // create if not found
                                $category = Category::create([
                                    'name' => $name,
                                    'slug' => Str::slug($name),
                                ]);
                            }

                            $categoryIds[] = $category->id;
                        }

                        // assign categories
                        $product->categories()->sync($categoryIds);

                    }
                    // gallery images (store as separate rows if you have images relation)
                    if (!empty($data['gallery_images'])) {
                        $imgs = explode('|', $data['gallery_images']);
                        foreach ($imgs as $img) {
                            $img = trim($img);
                            if ($img) {
                                $product->images()->firstOrCreate(['image' => $img]);
                            }
                        }
                    }

                    // variant processing (if is_variable or variant_sku provided)
                    if (!empty($data['variant_sku']) || $product->is_variable) {
                        // create/update variant
                        $variant = $product->variants()->updateOrCreate(
                            ['sku' => trim($data['variant_sku'])],
                            [
                                'variant_name' => trim($data['variant_sku']) ?? null,
                                'price' => is_numeric($data['variant_price']) ? $data['variant_price'] : 0,
                                'stock' => is_numeric($data['variant_stock']) ? intval($data['variant_stock']) : 0,
                                'image' => $data['variant_image'] ?? null,
                            ]
                        );

                        // variant attribute values sync
                        if (!empty($data['variant_attributes'])) {
                            // expecting format: Color=Red,Size=M
                            $pairs = array_filter(array_map('trim', explode(',', $data['variant_attributes'])));
                            $valueIds = [];

                            foreach ($pairs as $pair) {
                                if (strpos($pair, '=') === false)
                                    continue;
                                list($attrName, $val) = array_map('trim', explode('=', $pair, 2));
                                if (!$attrName || !$val)
                                    continue;

                                $attribute = Attribute::firstOrCreate(['name' => $attrName]);
                                $attrValue = $attribute->values()->firstOrCreate(['value' => $val]);
                                $valueIds[] = $attrValue->id;
                            }

                            if (!empty($valueIds)) {
                                $variant->values()->sync($valueIds);
                            }
                        }
                    }

                    DB::commit();
                    $processed++;
                } catch (\Throwable $e) {
                    DB::rollBack();
                    $failed++;
                    $errors[] = [
                        'row' => $rowNumber,
                        'error' => $e->getMessage(),
                        'data' => $data
                    ];
                }

                // periodic update (avoid too many updates)
                if (($processed + $failed) % 50 === 0) {
                    $import->update(['processed' => $processed, 'failed' => $failed]);
                }
            } // end while

            fclose($handle);
        } else {
            $import->update(['status' => 'failed', 'notes' => 'Unable to open file']);
            return;
        }

        // write errors csv (if any)
        $errorsFile = null;
        if (!empty($errors)) {
            // save errors into public/uploads/products/imports/errors
            $errorsDir = public_path('uploads/products/imports/errors');
            if (!is_dir($errorsDir)) {
                mkdir($errorsDir, 0755, true);
            }

            $errorsFilename = 'errors_' . $import->getKey() . '_' . time() . '.csv';
            $fullPath = $errorsDir . DIRECTORY_SEPARATOR . $errorsFilename;

            $handle = fopen($fullPath, 'w');
            if ($handle === false) {
                // if we cannot write the file, log and skip attaching an errors file
                Log::error('Unable to open errors file for writing', ['path' => $fullPath]);
            } else {
                fputcsv($handle, ['row', 'error', 'raw_data']);

                foreach ($errors as $err) {
                    fputcsv($handle, [
                        $err['row'],
                        $err['error'],
                        json_encode($err['data'], JSON_UNESCAPED_UNICODE)
                    ]);
                }
                fclose($handle);
                // store relative public path so it can be served
                $errorsFile = 'uploads/products/imports/errors/' . $errorsFilename;
            }
        }

        $import->update([
            'status' => 'done',
            'processed' => $processed,
            'failed' => $failed,
            'errors_file' => $errorsFile
        ]);
    }
}
