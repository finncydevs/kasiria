<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(['key' => 'app_name'], ['value' => 'Kasiria']);
        Setting::updateOrCreate(['key' => 'app_description'], ['value' => 'Sistem Manajemen Kasir Terintegrasi']);
        Setting::updateOrCreate(['key' => 'tax_rate'], ['value' => '0']); // Default 0%
        Setting::updateOrCreate(['key' => 'currency'], ['value' => 'IDR']);
    }
}
