<?php

namespace Database\Factories;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

class LivroFactory extends Factory
{
    protected $model = Livro::class;

    public function definition(): array
    {
        return [
            'nome'             => $this->faker->title(),
            'descricao'        => $this->faker->paragraph(1),
            'data_lancamento'  => $this->faker->date(),
            'id_editora'       => self::factoryForModel(Editora::class)->create()->id,
            'quantidade_total' => $this->faker->randomNumber(),
            'ativo'            => true,
            'id_autor'         => self::factoryForModel(Autor::class)->create()->id
        ];
    }
}
