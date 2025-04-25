<?php

namespace Database\Factories;

use App\Models\Authors;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Authors>
 */
class AuthorsFactory extends Factory
{
    protected $model = Authors::class;

    public function definition(): array
    {
        return [
            'name' => 'test author',
            'biography' => 'test author biography',
            'birthdate' => '1990-01-01',
        ];
    }
}
