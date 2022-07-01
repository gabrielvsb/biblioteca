<?php

namespace Tests\Feature;

use App\Models\Editora;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EditoraTest extends TestCase
{
    use DatabaseTransactions;

    public function test_exists_editoras(): void
    {
        Editora::factory()->count(3)->create();

        $this->json('GET', 'api/editora', ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    public function test_required_fields_editora(): void
    {
        $this->json('POST', 'api/editora', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                "message",
                "errors"
            ]);
    }

    public function test_insert_editora(): void
    {
        $data = [
            'nome' => 'Editora Teste'
        ];

        $this->json('POST', 'api/editora', $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(["message"]);
    }

    public function test_get_editora_by_id(): void
    {
        $editora = Editora::factory()->create();

        $this->json('GET', 'api/editora/'.$editora->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data"]);
    }

    public function test_update_editora(): void
    {
        $editora = Editora::factory()->create();

        $novosDados = [
            'nome' => 'Editora Novo'
        ];

        $this->putJson( 'api/editora/'.$editora->id, $novosDados, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_editora(): void
    {
        $editora = Editora::factory()->create();

        $this->deleteJson( 'api/editora/'.$editora->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function test_editora_not_exists(): void
    {
        $this->json('GET', 'api/editora/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"])
            ->assertJson(['message' => 'Não foi possível buscar a editora!']);
    }

    public function test_fail_insert_validate_fields_editora(): void
    {
        $data = [];

        $this->json('POST', 'api/editora', $data, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"]);
    }

    public function test_fail_delete_editora(): void
    {
        $this->deleteJson( 'api/editora/1000', ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJsonStructure(["message"]);
    }

    public function test_fail_update_editora(): void
    {
        $novosDados = [
            'nome' => 'Editora Nova'
        ];

        $this->putJson( 'api/editora/1000', $novosDados, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJsonStructure(["message"]);
    }

    public function test_dont_exists_records_from_editora(): void
    {
        Editora::query()->delete();
        $this->json('GET', 'api/editora', ['Accept' => 'application/json'])
            ->assertStatus(404);
    }
}
