<?php

namespace Tests\Feature;

use App\Models\Publisher;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PublisherTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->assignRole('employee');
    }

    public function test_exists_publishers(): void
    {
        Publisher::factory()->count(3)->create();

        $this->json('GET', 'api/publisher', ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    public function test_required_fields_publisher(): void
    {
        $this->actingAs($this->user)
            ->json('POST', 'api/publisher', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                "message",
                "errors"
            ]);
    }

    public function test_insert_publisher(): void
    {
        $data = [
            'name' => 'Publisher Teste'
        ];

        $this->actingAs($this->user)
            ->json('POST', 'api/publisher', $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(["message"]);
    }

    public function test_get_publisher_by_id(): void
    {
        $publisher = Publisher::factory()->create();

        $this->json('GET', 'api/publisher/'.$publisher->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data"]);
    }

    public function test_update_publisher(): void
    {
        $publisher = Publisher::factory()->create();

        $newData = [
            'nome' => 'Publisher Novo'
        ];

        $this->actingAs($this->user)
            ->putJson( 'api/publisher/'.$publisher->id, $newData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function test_publisher_not_exists(): void
    {
        $this->user->syncRoles(['admin']);
        $this->json('GET', 'api/publisher/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"])
            ->assertJson(['message' => 'Não foi possível buscar a editora!']);
    }

    public function test_fail_insert_validate_fields_publisher(): void
    {
        $data = [];

        $this->actingAs($this->user)
            ->json('POST', 'api/publisher', $data, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"]);
    }

    public function test_fail_update_publisher(): void
    {
        $newData = [
            'nome' => 'Publisher Nova'
        ];

        $this->actingAs($this->user)
            ->putJson( 'api/publisher/1000', $newData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJsonStructure(["message"]);
    }

    public function test_dont_exists_records_from_publisher(): void
    {
        Loan::query()->delete();
        Book::query()->delete();
        Publisher::query()->delete();

        $this->json('GET', 'api/publisher', ['Accept' => 'application/json'])
            ->assertStatus(404);
    }

    public function test_get_publisher_by_id_with_books(): void
    {
        $book = Book::factory()->create();

        $this->json('GET', 'api/publisher/'.$book->id_publisher.'/books', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data" => ["books"]]);
    }

    public function test_get_publisher_by_id_with_books_fails(): void
    {
        $this->json('GET', 'api/publisher/1000/books', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_fail_delete_publisher(): void
    {
        $this->user->syncRoles(['admin']);
        $this->actingAs($this->user)
            ->deleteJson( 'api/publisher/1000', ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_publisher(): void
    {
        $this->user->syncRoles(['admin']);
        $publisher = Publisher::factory()->create();

        $this->actingAs($this->user)
            ->deleteJson( 'api/publisher/'.$publisher->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }
}
