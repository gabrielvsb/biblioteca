<?php

namespace Tests\Feature;

use App\Models\{
    Autor,
    User
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AutorTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_get_all_autores(): void
    {
        Autor::factory()->count(3)->create();

        $this->json('GET', 'api/autor', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_fail_get_all_autores(): void
    {
        Autor::query()->delete();

        $this->json('GET', 'api/autor', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_get_autor_by_id(): void
    {
        $autor = Autor::factory()->create();

        $this->json('GET', 'api/autor/'.$autor->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_autor_by_id_fail(): void
    {
        $this->json('GET', 'api/autor/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_autor(): void
    {
        $autorAtributos = [
            'nome' => 'Jorge'
        ];

        $this->actingAs($this->user)
            ->json('POST', 'api/autor', $autorAtributos, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(["message"]);
    }

    public function test_insert_autor_fail_validate_fields(): void
    {
        $this->actingAs($this->user)
            ->json('POST', 'api/autor', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"]);
    }

    public function test_update_autor(): void
    {
        $autor= Autor::factory()->create();

        $novosDados = [
            'nome' => 'Pedro'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/autor/'.$autor->id, $novosDados, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function test_update_autor_fail(): void
    {
        $novosDados = [
            'nome' => 'Pedro'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/autor/1000', $novosDados, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_autor(): void
    {
        $autor = Autor::factory()->create();

        $this->actingAs($this->user)
            ->json('DELETE', 'api/autor/'.$autor->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_autor_fail(): void
    {
        $this->actingAs($this->user)
            ->json('DELETE', 'api/autor/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }
}
