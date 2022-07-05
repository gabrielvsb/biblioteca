<?php

namespace Database\Seeders;

use App\Models\Editora;
use App\Models\Emprestimo;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory()->count(3)->create();
        Editora::factory()->count(3)->create();
        Livro::factory()->count(3)->create();
        Emprestimo::factory()->create();
    }
}
