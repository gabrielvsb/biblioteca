<?php

namespace Database\Factories;

use App\Models\Livro;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmprestimoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_user' => self::factoryForModel(User::class)->create()->id,
            'id_livro' => self::factoryForModel(Livro::class)->create()->id,
            'data_inicio' => Carbon::now()->format('Y-m-d'),
            'data_fim' => Carbon::now()->addWeekdays(10)->format('Y-m-d'),
            'ativo' => true
        ];
    }
}
