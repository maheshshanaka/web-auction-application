<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\BidLog;
use App\Models\AutoBid;
use App\Models\Setting;
use App\Repositories\AutoBidBotRepository;
use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;

// use Tests\CreatesApplication;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\DatabaseTransactions;


class AutoBidBotTest extends TestCase
{

    use WithoutMiddleware;

    // use RefreshDatabase;
    // use CreatesApplication;
    // use DatabaseTransactions;

    protected $user1;
    protected $user2;
    protected $item;
    protected $autoBidBot;

    protected function setUp(): void
    {

        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();
        $this->item =  Item::factory()->create();

        Setting::create([
            'user_id'=> $this->user1->id,
            'max_bid_amount'=> 1750
        ]);

        Setting::create([
            'user_id'=> $this->user2->id,
            'max_bid_amount'=> 2750
        ]);

        AutoBid::create([
            'user_id' =>  $this->user1->id,
            'item_id'=>$this->item->id,
            'is_auto_bid' => 0,
        ]);

        AutoBid::create([
            'user_id' => $this->user2->id,
            'item_id'=>$this->item->id,
            'is_auto_bid' => 1,
        ]);

        BidLog::create([
            'item_id'=> $this->item->id,
            'user_id'=> $this->user1->id,
            'amount'=> 100,
            'is_auto_bid'=> 0
        ]);

        BidLog::create([
            'item_id'=> $this->item->id,
            'user_id'=> $this->user2->id,
            'amount'=> 110,
            'is_auto_bid'=> 1
        ]);

        $this->autoBidBot = new AutoBidBotRepository;


    }


    // get maximum Bid amount of the user
    public function testGetMaxBidAmount()
    {

        $maxBidAmount1 = $this->autoBidBot->getMaxBidAmount($this->user1->id);
        $maxBidAmount2 = $this->autoBidBot->getMaxBidAmount($this->user2->id);

        $this->assertIsNumeric($maxBidAmount1);
        $this->assertIsNumeric($maxBidAmount2);

        $result[] =  ['maxBidAmount'=>$maxBidAmount1,'user_id'=> $this->user1->id];
        $result[] =  ['maxBidAmount'=>$maxBidAmount2,'user_id'=> $this->user2->id];

        // print_r($result);
        return new Collection($result);

    }


    // get total spent amount for other items

    public function testSpentAmount()
    {

        $spentAmount1 = $this->autoBidBot->getSpentAmount($this->user1->id, $this->item->id);
        $spentAmount2 = $this->autoBidBot->getSpentAmount($this->user2->id, $this->item->id);

        $this->assertIsNumeric($spentAmount1);
        $this->assertIsNumeric($spentAmount2);

        $result[] =  ['spentAmount'=>$spentAmount1,'user_id'=> $this->user1->id, 'item_id'=>$this->item->id];
        $result[] =  ['spentAmount'=>$spentAmount2,'user_id'=> $this->user2->id, 'item_id'=>$this->item->id];

        // print_r($result);

        return $result;

    }


    // get availble bid amount amount of the user
    public function testAvailbleBidAmount()
    {

        $availbleBidAmount1 = $this->autoBidBot->getAvailbleBidAmount($this->user1->id, $this->item->id);
        $availbleBidAmount2 = $this->autoBidBot->getAvailbleBidAmount($this->user2->id, $this->item->id);

        $this->assertIsNumeric($availbleBidAmount1);
        $this->assertIsNumeric($availbleBidAmount2);

        $result[] =  ['availbleBidAmount'=>$availbleBidAmount1,'user_id'=> $this->user1->id, 'item_id'=>$this->item->id];
        $result[] =  ['availbleBidAmount'=>$availbleBidAmount2,'user_id'=> $this->user2->id, 'item_id'=>$this->item->id];

        // print_r($result);

        return $result;

    }

     // get last bid amount of the item
     public function testHighestBidByItem()
     {

        $highestBid1 = $this->autoBidBot->getHighestBid($this->item->id);
        $highestBid2 = $this->autoBidBot->getHighestBid($this->item->id);

        $this->assertIsNumeric($highestBid1);
        $this->assertIsNumeric($highestBid2);

        $result[] =  ['highestBid'=>$highestBid1,'item_id'=>$this->item->id];
        $result[] =  ['availbleBidAmount'=>$highestBid2,'item_id'=>$this->item->id];

        // print_r($result);

        return $result;

     }



    // get auto bid users for given items
    public function testAutoBidUsersByItems()
    {

        $autoBidUsersByItems1 = $this->actingAs($this->user1)
        ->autoBidBot->getAutoBidUsersByItems($this->item->id,100);

        $autoBidUsersByItems2 = $this->actingAs($this->user2)
        ->autoBidBot->getAutoBidUsersByItems($this->item->id,200);

        $this->assertNotNull($autoBidUsersByItems1);
        $this->assertNotNull($autoBidUsersByItems2);

    }


    // When someone bids on an item, the Auto Bid bot starts automatically.
    public function testStartAutoBidBot(){

        $startAutoBidBot = $this->actingAs($this->user1)
        ->autoBidBot->startAutoBidBot($this->item->id);

        $this->assertTrue($startAutoBidBot);

    }


    public function testCreateBidAutoBidFinal()
    {

        $filteredBidInfos[] = array(
            'availble_bid_amount' => 1000,
            'last_bid' => 120,
            'user_id' => $this->user1->id,
            'item_id' => $this->item->id
        );

        $filteredBidInfos[] = array(
            'availble_bid_amount' => 900,
            'last_bid' => 190,
            'user_id' => $this->user1->id,
            'item_id' => $this->item->id
        );

        $collection = new Collection($filteredBidInfos);
        //  no contest with bidders
        if ($collection->count() == 1) {
            $data['user_id'] = $collection[0]['user_id'];
            $data['item_id'] = $collection[0]['item_id'];
            $data['amount'] = $collection[0]['last_bid'] + 1;
            $data['is_auto_bid'] = true;
        } else {
            $collectionSortByDesc = $collection->sortByDesc('availble_bid_amount')->values()->all();
            //
            // get Auto bid user who possible to pay highest amount
            $data['user_id'] = $collectionSortByDesc[0]['user_id'];
            $data['item_id'] = $collectionSortByDesc[0]['item_id'];
            $data['amount'] = $collectionSortByDesc[1]['availble_bid_amount'] + 1; // second higher auto bidder value
            $data['is_auto_bid'] = true;
        }
        $result = BidLog::create($data);
        if ($result) {

            $this->assertTrue(true);
        } else {
            $this->assertFalse(true);
        }
    }



}
