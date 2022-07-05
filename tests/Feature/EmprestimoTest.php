<?php

namespace Tests\Feature;

use App\Models\Emprestimo;
use App\Models\Livro;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmprestimoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_all_emprestimos(): void
    {
        Emprestimo::factory()->count(3)->create();

        $this->json('GET', 'api/emprestimo', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_get_all_emprestimos_fail(): void
    {
        Emprestimo::query()->delete();

        $this->json('GET', 'api/emprestimo', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_emprestimo(): void
    {
        $usuario = User::factory()->create();
        $livro = Livro::factory()->create();

        $emprestimoAtributos = [
            'id_user' => $usuario->id,
            'id_livro' => $livro->id,
        ];

        $this->json('POST', 'api/emprestimo', $emprestimoAtributos, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_emprestimo_validate_fields(): void
    {
        $this->json('POST', 'api/emprestimo', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    public function test_get_emprestimo_by_id(): void
    {
        $emprestimo = Emprestimo::factory()->create();

        $this->json('GET', 'api/emprestimo/'.$emprestimo->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_emprestimo_by_id_fail(): void
    {
        $this->json('GET', 'api/emprestimo/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_update_emprestimo(): void
    {
        $emprestimo = Emprestimo::factory()->create();

        $novoAtributo = [
            'ativo' => false
        ];

        $this->json('PUT', 'api/emprestimo/'.$emprestimo->id, $novoAtributo, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_update_emprestimo_fail()
    {
        $novoAtributo = [
            'ativo' => false
        ];

        $this->json('PUT', 'api/emprestimo/1000', $novoAtributo, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_emprestimo(): void
    {
        $emprestimo = Emprestimo::factory()->create();

        $this->json('DELETE', 'api/emprestimo/'.$emprestimo->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_emprestimo_fail()
    {
        $this->json('DELETE', 'api/emprestimo/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
}
