<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            [
                'name' => 'Size',
                'slug' => 'size',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'Color',
                'slug' => 'color',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];
        $values = [
            [
                'value' => 'S',
                'attribute_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'M',
                'attribute_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'L',
                'attribute_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'Blue',
                'attribute_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'Red',
                'attribute_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AttributeValue::truncate();
        Attribute::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Attribute::insertOrIgnore($attributes);
        AttributeValue::insertOrIgnore($values);
    }
}
