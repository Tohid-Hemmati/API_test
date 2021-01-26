<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween($min = 1, $max = 10000000),
            'uID' => $this->faker->numberBetween($min = 1, $max = 10000000),
            'appID' => $this->faker->unique()->numberBetween($min = 1, $max = 10000000),
            'OS' => $this->faker->randomElement(['Android', 'ios']),
            'lang' => $this->faker->randomElement(['en', 'tr', 'fr']),
            'client_token' =>Str::random(40),
            'created_at' => $this->faker->dateTime($max = 'now', $timezone = null),
            'updated_at' => $this->faker->dateTime($max = 'now', $timezone = null)
        ];
    }
}
