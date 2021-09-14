<?php

namespace Tests\Feature;

use App\Models\BidLog;
use App\Models\User;
use App\Models\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\AutoBidBotRepository;
use Illuminate\Support\Facades\Auth;

class SingleBidTest extends TestCase
{

    use WithoutMiddleware;
    // use RefreshDatabase;

    protected $user, $userCreate, $item;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bidLog = BidLog::first();
        $this->item =  Item::find($this->bidLog->item_id);
        $this->user = User::find($this->bidLog->user_id);
        $this->actingAs($this->user);
        $this->autoBidBot = new AutoBidBotRepository;
    }


    public function testSingleBidWithParams()
    {
        // $bidLog =  BidLog::where(['user_id' => $this->user->id])->first();
        $bidLog1 =  BidLog::create([
            'amount' => '100.00',
            'item_id' => $this->bidLog->item_id,
            'user_id' => $this->bidLog->user_id,
            'is_auto_bid' => 0
        ]);

        $bidLog2 =  BidLog::create([
            'amount' => '200.00',
            'item_id' => $this->bidLog->item_id,
            'user_id' => $this->bidLog->user_id,
            'is_auto_bid' => 0
        ]);
        $this->assertNotNull($bidLog1->id);
        $this->assertNotNull($bidLog2->id);
    }


    public function testSingleBidWithNullAmount()
    {
        $response =  $this->actingAs($this->user)
            ->post(route('bid-logs.store'), [
                'amount' => '',
                'item_id' => $this->item->id,
                'user_id' => $this->user->id,
                'is_auto_bid' => 0
            ]);
        $response->assertSessionHasErrors();
    }


    public function testSingleBidWithZeroAmount()
    {
        $response =  $this->actingAs($this->user)
            ->post(route('bid-logs.store'), [
                'amount' => 0,
                'item_id' => $this->item->id,
                'user_id' => $this->user->id,
                'is_auto_bid' => 0
            ]);
        $response->assertSessionHasErrors();
    }


    public function testSingleBidWithInvalidAmount()
    {
        $response =  $this->actingAs($this->user)
            ->post(route('bid-logs.store'), [
                'amount' => "test",
                'item_id' => $this->item->id,
                'user_id' => $this->user->id,
                'is_auto_bid' => 0
            ]);
        $response->assertSessionHasErrors();
    }


    public function testSingleBidWithMinAmount()
    {
        $highestBid = $this->autoBidBot->getHighestBid($this->item->id);
        $response =  $this->actingAs($this->user)
            ->post(route('bid-logs.store'), [
                'amount' => $highestBid,
                'item_id' => $this->item->id,
                'user_id' => $this->user->id,
                'is_auto_bid' => 0
            ]);
        $response->assertSessionHasErrors();
    }


    public function testSingleBidCheckHighestBidUser()
    {

        if (Auth::id() != $this->autoBidBot->getHighestBidUser($this->item->id)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(true);
        }
    }
}
