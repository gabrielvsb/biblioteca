<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class CopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'isbn'       => $this->faker->numerify('###-#-####-####-#'),
            'id_book'    => self::factoryForModel(Book::class)->create()->id,
            'status'     => 'A'
        ];
    }
}
