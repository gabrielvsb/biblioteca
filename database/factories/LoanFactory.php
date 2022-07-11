<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_user'    => self::factoryForModel(User::class)->create()->id,
            'id_book'    => self::factoryForModel(Book::class)->create()->id,
            'date_start' => Carbon::now()->format('Y-m-d'),
            'date_end'   => Carbon::now()->addWeekdays(10)->format('Y-m-d'),
            'active'     => true
        ];
    }
}
