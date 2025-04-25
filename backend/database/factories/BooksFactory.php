<?php

namespace Database\Factories;

use App\Models\Authors;
use App\Models\Books;
use Illuminate\Database\Eloquent\Factories\Factory;

class BooksFactory extends Factory
{
    protected $model = Books::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'description' => $this->faker->paragraph,
            'published_date' => $this->faker->date,
            'cover_url' => $this->faker->imageUrl(),
            'author_id' => Authors::factory(),
        ];
    
    }
}
