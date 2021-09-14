<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [
            'images' =>$this->faker->numberBetween(1,5).".jpg",
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1,100),
            // 'slug' => $this->faker->sentence,
            'auction_end_time' => $this->faker->dateTimeBetween('now', '+ 1 month')->format('Y-m-d h:m:s')

        ];
    }
}
