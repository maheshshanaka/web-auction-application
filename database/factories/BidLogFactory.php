<?php

namespace Database\Factories;

use App\Models\BidLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BidLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'amount' => $this->faker->numberBetween(101,150),
            'item_id' => $this->faker->numberBetween(1,5),
            'user_id' => $this->faker->numberBetween(1,2),
            'is_auto_bid' => $this->faker->numberBetween(0,1),
        ];
    }
}
