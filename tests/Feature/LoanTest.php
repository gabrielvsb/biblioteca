<?php

namespace Tests\Feature;

use App\Models\Copy;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->assignRole('employee');
    }

    public function test_get_all_loans(): void
    {
        Loan::factory()->count(3)->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/loan', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_get_all_loans_fail(): void
    {
        Loan::query()->delete();

        $this->actingAs($this->user)
            ->json('GET', 'api/loan', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_loan(): void
    {
        $user = User::factory()->create();
        $copy = Copy::factory()->create();

        $loanAtributos = [
            'id_user' => $user->id,
            'id_copy' => $copy->id,
        ];

        $this->actingAs($this->user)
            ->json('POST', 'api/loan', $loanAtributos, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure(['message']);
    }

    public function test_insert_loan_validate_fields(): void
    {
        $this->actingAs($this->user)
            ->json('POST', 'api/loan', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    public function test_get_loan_by_id(): void
    {
        $loan = Loan::factory()->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/loan/'.$loan->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_loan_by_id_fail(): void
    {
        $this->actingAs($this->user)
            ->json('GET', 'api/loan/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_update_loan(): void
    {
        $loan = Loan::factory()->create();

        $novoAtributo = [
            'active' => false
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/loan/'.$loan->id, $novoAtributo, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_update_loan_fail()
    {
        $novoAtributo = [
            'active' => false
        ];

        $this->actingAs($this->user)
            ->json('PUT', 'api/loan/1000', $novoAtributo, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_get_loan_with_book(): void
    {
        $loan = Loan::factory()->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/loan/'.$loan->id.'/book', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data" => ["copy" => ["book"]]]);
    }

    public function test_get_loan_with_user(): void
    {
        $loan = Loan::factory()->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/loan/'.$loan->id.'/user', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data" => ["user"]]);
    }

    public function test_get_loan_with_complete_detail(): void
    {
        $loan = Loan::factory()->create();

        $this->actingAs($this->user)
            ->json('GET', 'api/loan/'.$loan->id.'/complete', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["data" => ["user", "copy" => ["book"]]]);
    }

    public function test_get_loan_with_book_fail(): void
    {
        $this->actingAs($this->user)
            ->json('GET', 'api/loan/1000/book', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_get_loan_with_user_fail(): void
    {
        $this->actingAs($this->user)
            ->json('GET', 'api/loan/1000/user', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_get_loan_with_complete_detail_fail(): void
    {
        $this->actingAs($this->user)
            ->json('GET', 'api/loan/1000/complete', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(["message"]);
    }

    public function test_delete_loan(): void
    {
        $this->user->syncRoles(['admin']);
        $loan = Loan::factory()->create();

        $this->actingAs($this->user)
            ->json('DELETE', 'api/loan/'.$loan->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_loan_fail()
    {
        $this->user->syncRoles(['admin']);
        $this->actingAs($this->user)
            ->json('DELETE', 'api/loan/1000', ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
}
