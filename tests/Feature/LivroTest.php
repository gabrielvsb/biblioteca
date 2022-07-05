<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Emprestimo;
use App\Models\Livro;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LivroTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_all_livros(): void
    {
        Livro::factory()->count(3)->create();

        $this->json('GET', 'api/livro', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_get_all_livros_fail(): void
    {
        Emprestimo::query()->delete();
        Livro::query()->delete();

        $this->json('GET', 'api/livro', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_livro(): void
    {
        $autor = Autor::factory()->create();
        $editora = Editora::factory()->create();

        $livroAtributos = [
            'nome'             => 'Livro 1',
            'descricao'        => 'Descricao do livro 1',
            'data_lancamento'  => '2022-01-01',
            'id_editora'       => $editora->id,
            'quantidade_total' => rand(1,9),
            'ativo'            => true,
            'id_autor'         => $autor->id
        ];

        $this->json('POST', 'api/livro', $livroAtributos, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(["message"]);

    }

    public function test_insert_livro_validate_fields_fail(): void
    {
        $this->json('POST', 'api/livro', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"]);
    }

    public function test_get_livro_by_id(): void
    {
        $livro = Livro::factory()->create();

        $this->json('GET', 'api/livro/'.$livro->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_livro_by_id_fail(): void
    {
        $this->json('GET', 'api/livro/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_update_livro(): void
    {
        $livro = Livro::factory()->create();

        $novosDados = [
            'nome' => 'Livro teste atualização'
        ];

        $this->json('PUT', 'api/livro/'.$livro->id, $novosDados, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_test_update_livro_fail(): void
    {
        $novosDados = [
            'nome' => 'Livro teste atualização'
        ];

        $this->json('PUT', 'api/livro/1000', $novosDados, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_livro(): void
    {
        $livro = Livro::factory()->create();

        $this->json('DELETE', 'api/livro/'.$livro->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_livro_fail(): void
    {
        $this->json('DELETE', 'api/livro/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
}
