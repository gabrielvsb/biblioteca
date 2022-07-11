<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddColumnAuthorIdBooksTable extends Migration
{
    public function up(): void
    {
        Schema::table('books', function($table) {
            $table->foreignIdFor(\App\Models\Author::class);;
        });
    }

    public function down(): void
    {
        Schema::table('users', function($table) {
            $table->dropForeignIdFor(\App\Models\Author::class);
        });
    }
}
