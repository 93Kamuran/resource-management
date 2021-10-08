<?php


namespace Database\Factories;


use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory  extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Link::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'link' => $this->faker->url(),
            'target'=>'_self'
        ];
    }
}