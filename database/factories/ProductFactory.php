<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if (rand(0, 1)) {
            $publishedAt = $this->faker->dateTime();
        } else {
            $publishedAt = null;
        }

        return [
            'title' => $this->faker->text(100),
            'description' => $this->faker->text(300),
            'images' => json_encode([
                ['name' => $this->faker->text(20), 'url' => $this->faker->imageUrl(), 'main' => true],
                ['name' => $this->faker->text(20), 'url' => $this->faker->imageUrl()],
                ['name' => $this->faker->text(20), 'url' => $this->faker->imageUrl()],
            ]),
            'price' => $this->faker->numberBetween($min = 1, $max = 1000),
            'published_at' => $publishedAt,
            'deleted_at' => null,
        ];
    }

    public function deleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => $this->faker->dateTime(),
            ];
        });
    }
}
