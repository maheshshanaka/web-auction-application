<?php

namespace Tests\Feature;

use App\Models\BidLog;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class SettingsTest extends TestCase
{

    use WithoutMiddleware;

    protected $user, $userCreate, $item;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bidLog = BidLog::first();
        $this->user = User::find($this->bidLog->user_id);
        $this->actingAs($this->user);
    }


    public function testSettingsWithParams()
    {
        $user2 =  User::factory()->create();
        $user3 =  User::factory()->create();
        $response1 =  $this->actingAs($this->user)
            ->post(route('settings.store'), [
                'max_bid_amount' => 6500,
                'user_id' => $this->user,
            ]);
        $response1->assertSessionHasNoErrors();
        $response2 =  $this->actingAs($this->user)
            ->post(route('settings.store'), [
                'max_bid_amount' => 4500,
                'user_id' =>  $user2->id
            ]);

        $response2->assertSessionHasNoErrors();
        $response3 =  $this->actingAs($this->user)
            ->post(route('settings.store'), [
                'max_bid_amount' => 4500,
                'user_id' =>  $user3->id
            ]);
        $response3->assertSessionHasNoErrors();
    }


    public function testSettingsWithNullMaxBidAmount()
    {
        $response =  $this->actingAs($this->user)
            ->post(route('settings.store'), [
                'max_bid_amount' => null,
                'user_id' => $this->user->id,
            ]);
        $response->assertSessionHasErrors();
    }


    public function testSettingsWithInvalidMaxBidAmount()
    {
        $response =  $this->actingAs($this->user)
            ->post(route('settings.store'), [
                'max_bid_amount' => "test",
                'user_id' => $this->user->id,
            ]);
        $response->assertSessionHasErrors();
    }
}
