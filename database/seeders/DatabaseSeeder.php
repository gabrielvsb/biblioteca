<?php

namespace Database\Seeders;

use App\Models\Publisher;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory()->count(3)->create();
        Publisher::factory()->count(3)->create();
        Book::factory()->count(3)->create();
        Loan::factory()->create();
    }
}
