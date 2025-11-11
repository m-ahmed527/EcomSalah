<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'site_name' => 'SalahWears',
            'site_email' => 'info@mywebsite.com',
            'site_phone' => '923001234567',
            'logo' => 'http://127.0.0.1:8001/uploads/settings/logo_1761350078_sw_favicon.png',
            'favicon' => 'http://127.0.0.1:8001/uploads/settings/favicon_1761340884_Adobe Express - file.png',
            'facebook' => null,
            'twitter' => null,
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => '587',
            'mail_username' => '',
            'mail_password' => '',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
