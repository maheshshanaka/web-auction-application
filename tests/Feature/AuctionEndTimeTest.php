<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuctionEndTimeTest extends TestCase
{

    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->item =  Item::factory()->create();

        $this->user = User::first();
        $this->actingAs($this->user);
    }


    // Check maximum bid amount without item_id field
    public function testMaximumBidAmountWithoutItemId()
    {

        $response =  $this->actingAs($this->user)
            ->post(route('items.store'), [
                'auction_end_time' => "2021-10-12 11:01:59",
                'item_id' => null
            ]);

        $response->assertSessionHasErrors(['item_id']);
    }

    // Check maximum bid amount without auctionEndTime field
    public function testMaximumBidAmountWithoutauctionEndTime()
    {

        $response =  $this->actingAs($this->user)
            ->post(route('items.store'), [
                'auction_end_time' => null,
                'item_id' => 1
            ]);

        $response->assertSessionHasErrors(['auction_end_time']);
    }


     // Check maximum bid amount with correct params
    public function testMaximumBidAmountWithParams()
    {

        $bidLog1 =  $this->actingAs($this->user)
            ->post(route('items.store'), [
                'auction_end_time' => '2021-09-12 10:09:59',
                'item_id' => $this->item->id
            ])->assertRedirect(route('items.index'));


            $bidLog2 =  $this->actingAs($this->user)
            ->post(route('items.store'), [
                'auction_end_time' => '2021-12-11 10:09:59',
                'item_id' => $this->item->id
            ])->assertRedirect(route('items.index'));

    }
}
