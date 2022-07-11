<?php

namespace Tests\Feature;

use App\Models\{
    Author,
    User
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->assignRole('employee');
    }

    public function test_get_all_authors(): void
    {
        Author::factory()->count(3)->create();

        $this->json('GET', 'api/author', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_fail_get_all_authors(): void
    {
        Author::query()->delete();

        $this->json('GET', 'api/author', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_get_author_by_id(): void
    {
        $author = Author::factory()->create();

        $this->json('GET', 'api/author/'.$author->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_author_by_id_fail(): void
    {
        $this->json('GET', 'api/author/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_author(): void
    {
        $authorAtributos = [
            'name' => 'Jorge'
        ];

        $this->actingAs($this->user)
            ->json('POST', 'api/author', $authorAtributos, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(["message"]);
    }

    public function test_insert_author_fail_validate_fields(): void
    {
        $this->actingAs($this->user)
            ->json('POST', 'api/author', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"]);
    }

    public function test_update_author(): void
    {
        $author = Author::factory()->create();

        $newData = [
            'name' => 'Pedro'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/author/'.$author->id, $newData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function test_update_author_fail(): void
    {
        $newData = [
            'name' => 'Pedro'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/author/1000', $newData, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_author(): void
    {
        $this->user->syncRoles(['admin']);
        $author = Author::factory()->create();

        $this->actingAs($this->user)
            ->json('DELETE', 'api/author/'.$author->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_author_fail(): void
    {
        $this->user->syncRoles(['admin']);
        $this->actingAs($this->user)
            ->json('DELETE', 'api/author/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }
}
