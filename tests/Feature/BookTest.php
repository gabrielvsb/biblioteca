<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Publisher;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->assignRole('employee');
    }

    public function test_get_all_books(): void
    {
        Book::factory()->count(3)->create();

        $this->json('GET', 'api/book', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_get_all_books_fail(): void
    {
        Loan::query()->delete();
        Book::query()->delete();

        $this->json('GET', 'api/book', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_book(): void
    {
        $athor = Author::factory()->create();
        $publisher = Publisher::factory()->create();

        $bookAttributes = [
            'name'             => 'Book 1',
            'description'      => 'Descricao do book 1',
            'release_date'     => '2022-01-01',
            'id_publisher'     => $publisher->id,
            'total_amount'     => rand(1,9),
            'active'           => true,
            'id_author'        => $athor->id
        ];

        $this->actingAs($this->user)
            ->json('POST', 'api/book', $bookAttributes, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(["message"]);

    }

    public function test_insert_book_validate_fields_fail(): void
    {
        $this->actingAs($this->user)
            ->json('POST', 'api/book', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"]);
    }

    public function test_get_book_by_id(): void
    {
        $book = Book::factory()->create();

        $this->json('GET', 'api/book/'.$book->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_book_by_id_fail(): void
    {
        $this->json('GET', 'api/book/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_update_book(): void
    {
        $book = Book::factory()->create();

        $newData = [
            'nome' => 'Book teste atualização'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/book/'.$book->id, $newData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_test_update_book_fail(): void
    {
        $newData = [
            'name' => 'Book teste atualização'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/book/1000', $newData, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_get_book_with_loans(): void
    {
        $loan = Loan::factory()->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/book/'.$loan->id_book.'/loans', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data" => ["loans"]]);
    }

    public function test_get_book_with_loans_fail(): void
    {
        $this->actingAs($this->user)
            ->json('GET', 'api/book/1000/loans', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_get_book_with_author(): void
    {
        $book = Book::factory()->create();

        $this->json('GET', 'api/book/'.$book->id.'/author', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data" => ["author"]]);
    }

    public function test_get_book_with_author_fail(): void
    {
        $this->json('GET', 'api/book/1000/author', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_get_book_with_publisher(): void
    {
        $book = Book::factory()->create();

        $this->json('GET', 'api/book/'.$book->id.'/publisher', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data" => ["publisher"]]);
    }

    public function test_get_book_with_editora_fail(): void
    {
        $this->json('GET', 'api/book/1000/editora', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_book(): void
    {
        $this->user->syncRoles(['admin']);
        $book = Book::factory()->create();

        $this->actingAs($this->user)
            ->json('DELETE', 'api/book/'.$book->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_book_fail(): void
    {
        $this->user->syncRoles(['admin']);
        $this->actingAs($this->user)
            ->json('DELETE', 'api/book/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
}
