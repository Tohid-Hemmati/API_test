<?php

namespace Database\Factories;

use App\Models\MobileApp;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MobileAppFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MobileApp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween($min = 1, $max = 10000000),
            'device_id' => $this->faker->numberBetween($min = 1, $max = 10000000),
            'device_OS' => $this->faker->randomElement(['Android', 'ios']),
            'name' => $this->faker->word,
            'app_token' =>Str::random(40),
            'in_app_purchase' =>$this->faker->boolean,
            'subscription_status' =>$this->faker->boolean,
            'register_time' => $this->faker->dateTime($max = 'now', $timezone = null),
        ];
    }
}
