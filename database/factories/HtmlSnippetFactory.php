<?php

namespace Database\Factories;

use App\Models\HtmlSnippet;
use Illuminate\Database\Eloquent\Factories\Factory;

class HtmlSnippetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HtmlSnippet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'title' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'description' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'html' => $this->faker->randomHtml(),

        ];
    }
}
