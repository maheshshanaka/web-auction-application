<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();

        // \App\Models\User::factory(1)->create();

        \App\Models\User::truncate();
        $this->call(UsersTableSeeder::class);

        \App\Models\Item::truncate();
        \App\Models\Item::factory(20)->create();

        \App\Models\Setting::truncate();
        $this->call(SettingsTableSeeder::class);

        \App\Models\AutoBid::truncate();
        $this->call(AutoBidTableSeeder::class);

        \App\Models\BidLog::truncate();
        $this->call(BidLogTableSeeder::class);


        // \App\Models\BidLog::factory(20)->create();
        // \App\Models\AutoBid::factory(2)->create();
        // \App\Models\Setting::factory(2)->create();



    }
}
