<?php
namespace Database\Seeders;

use App\Models\AutoBid;
use Illuminate\Database\Seeder;

class AutoBidTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        AutoBid::create([
            'user_id' => 1,
            'item_id'=>1,
            'is_auto_bid' => 0,
        ]);

        AutoBid::create([
            'user_id' => 2,
            'item_id'=>1,
            'is_auto_bid' => 1,
        ]);




    }
}
