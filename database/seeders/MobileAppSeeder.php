<?php

namespace Database\Seeders;

use App\Models\MobileApp;
use Illuminate\Database\Seeder;

class MobileAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MobileApp::factory()->count(10000)->create();
    }
}
