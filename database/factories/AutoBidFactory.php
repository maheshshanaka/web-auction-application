<?php

namespace Database\Factories;

use App\Models\AutoBid;
use Illuminate\Database\Eloquent\Factories\Factory;

class AutoBidFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AutoBid::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [

            'item_id' => 1, //set 1 for testting
            // 'item_id' => $this->faker->numberBetween(1,10),
            'user_id' => $this->faker->numberBetween(1,2),
            'is_auto_bid' =>$this->faker->numberBetween(0,1),
        ];
    }
}
