<?php
namespace Database\Seeders;

use App\Models\BidLog;
use Illuminate\Database\Seeder;

class BidLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        BidLog::create([
            'user_id' => 1,
            'item_id'=>1,
            'amount' => 100,
            'is_auto_bid' => 0,
        ]);

        BidLog::create([
            'user_id' => 2,
            'item_id'=>1,
            'amount' => 101,
            'is_auto_bid' => 1,
        ]);

        BidLog::create([
            'user_id' => 1,
            'item_id'=>1,
            'amount' => 110,
            'is_auto_bid' => 0,
        ]);

        BidLog::create([
            'user_id' => 2,
            'item_id'=>1,
            'amount' => 115,
            'is_auto_bid' => 1,
        ]);
        BidLog::create([
            'user_id' => 2,
            'item_id'=>2,
            'amount' => 103,
            'is_auto_bid' => 1,
        ]);





    }
}
