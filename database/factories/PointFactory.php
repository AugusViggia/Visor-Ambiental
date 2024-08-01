<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Ecoregion;
use App\Models\Geometry;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point as GeospatialPoint;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Point>
 */
class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = Category::inRandomOrder()->first();

        $point = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'institution' => $this->faker->company,
            'source' => $this->faker->company,
            'url' => $this->faker->url,
            'year' => $this->faker->year,
            'month' => $this->faker->month,
            'geometry_id' => function () {
                return Geometry::inRandomOrder()->first()->id;
            },
            'altitude' => $this->faker->randomFloat(2, 0, 3200),
            'category_id' => function () use ($category) {
                return $category->id;
            },
            'subcategory_id' => function () use ($category) {
                return optional($category->subcategories()->inRandomOrder()->first())->id;
            },
            'ecoregion_id' => function () {
                return Ecoregion::inRandomOrder()->first()->id;
            },
            'location' => function () {
                return new GeospatialPoint(
                    $this->faker->latitude(-26, -22),
                    $this->faker->longitude(-68.5, -63)
                );
            },
            'taxa' => $this->faker->numberBetween(30, 3000),
            'user_id' => User::factory(),
            'status_id' => function () {
                return Status::inRandomOrder()->first()->id;
            },
        ];

        $hash = hash('sha256', json_encode($point));

        $point['hash'] = $hash;

        return $point;

    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => config('custom.points.status.approved'),
                'approved_by' => function () {
                    return User::role('ADM')->inRandomOrder()->first()->id;
                },
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => config('custom.points.status.rejected'),
                'rejected_by' => function () {
                    return User::role('ADM')->inRandomOrder()->first()->id;
                },
            ];
        });
    }

    public function denounced()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => config('custom.points.status.denounced'),
                'rejected_by' => User::factory()->approved(),
            ];
        });
    }
}
