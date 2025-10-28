<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $guarded = ['id'];


    public static function get($key, $default = null)
    {
        // Cache for performance
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            return optional(static::where('key', $key)->first())->value ?? $default;
        });
    }

    // Set a single setting
    public static function set($key, $value)
    {
        cache()->forget("setting_{$key}");
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    // Bulk update method (one DB hit)
    public static function updateSettings(array $data)
    {
        DB::transaction(function () use ($data) {
            $records = [];
            $time = now();

            foreach ($data as $key => $value) {
                $records[] = [
                    'key' => $key,
                    'value' => $value,
                    'updated_at' => $time,
                ];
            }

            // upsert in one query
            static::upsert($records, ['key'], ['value', 'updated_at']);

            // clear cache for all updated keys
            foreach (array_keys($data) as $key) {
                cache()->forget("setting_{$key}");
            }
        });
    }
}
