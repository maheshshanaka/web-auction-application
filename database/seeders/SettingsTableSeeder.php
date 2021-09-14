<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Setting::create([
            'user_id' => 1,
            'max_bid_amount' => 1100,
        ]);

        Setting::create([
            'user_id' => 2,
            'max_bid_amount' => 1250,
        ]);


    }
}
