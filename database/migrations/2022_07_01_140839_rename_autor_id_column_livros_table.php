<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAutorIdColumnLivrosTable extends Migration
{
    public function up(): void
    {
        Schema::table('livros', function($table)
        {
            $table->renameColumn('autor_id', 'id_autor');
        });
    }

    public function down(): void
    {
        Schema::table('livros', function($table)
        {
            $table->renameColumn('id_autor', 'autor_id');
        });
    }
}
