<?php

namespace Database\Factories;

use App\Models\PdfResource;
use Illuminate\Database\Eloquent\Factories\Factory;

class PdfResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PdfResource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

                'title' => $this->faker->regexify('[A-Za-z0-9]{20}'),
                'path' => $this->faker->filePath(),

        ];
    }
}
