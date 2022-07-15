<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Publisher;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'name'               => $this->faker->title(),
            'description'        => $this->faker->paragraph(1),
            'release_date'       => $this->faker->date(),
            'id_publisher'       => self::factoryForModel(Publisher::class)->create()->id,
            'active'             => true,
            'id_author'          => self::factoryForModel(Author::class)->create()->id
        ];
    }
}
