<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $authors = collect(Author::pluck('id'));

        return [
            'author_id' => $authors->random(),
            'name' => $this->faker->words(asText: true),
            'description' => $this->faker->text(50),
            'codebar' => $this->faker->isbn10(),
        ];
    }
}
