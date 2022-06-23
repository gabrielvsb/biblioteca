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
        $editora = Editora::factory()->make();

        $this->json('GET', 'api/editora/'.$editora->id, ['Accept' => 'application/json'])
            ->assertStatus(200);
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
}
