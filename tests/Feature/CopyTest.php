<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Copy;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CopyTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->assignRole('employee');
    }

    public function test_get_all_copies(): void
    {
        Copy::factory()->count(3)->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/copy', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_get_all_copies_fail(): void
    {
        Loan::query()->delete();
        Copy::query()->delete();

        $this->actingAs($this->user)
            ->json('GET', 'api/copy', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_get_copy_by_id(): void
    {
        $copy = Copy::factory()->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/copy/'.$copy->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_copy_by_id_fail(): void
    {
        $this->actingAs($this->user)
            ->json('GET', 'api/copy/100000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_copy(): void
    {
        $book = Book::factory()->create();

        $copyAttributes = [
            'isbn'    => '452-0-5412-5215-2',
            'id_book' => $book->id,
            'status'  => 'A'
        ];

        $this->actingAs($this->user)
            ->json('POST', 'api/copy', $copyAttributes, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_copy_fail_validate_errors(): void
    {
        $this->actingAs($this->user)
            ->json('POST', 'api/copy', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    public function test_update_copy(): void
    {
        $copy = Copy::factory()->create();

        $newData = [
            'status' => 'L'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/copy/'.$copy->id, $newData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_update_copy_fail(): void
    {
        $newData = [
            'status' => 'L'
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/copy/10000', $newData, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_copy(): void
    {
        $this->user->syncRoles(['admin']);

        $copy = Copy::factory()->create();

        $this->actingAs($this->user)
            ->json('DELETE', 'api/copy/'.$copy->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_copy_fail(): void
    {
        $this->user->syncRoles(['admin']);

        $this->actingAs($this->user)
            ->json('DELETE', 'api/copy/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
}
