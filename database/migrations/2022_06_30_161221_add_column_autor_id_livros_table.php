<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddColumnAutorIdLivrosTable extends Migration
{
    public function up(): void
    {
        Schema::table('livros', function($table) {
            $table->foreignIdFor(\App\Models\Autor::class);;
        });
    }

    public function down(): void
    {
        Schema::table('users', function($table) {
            $table->dropForeignIdFor(\App\Models\Autor::class);
        });
    }
}
