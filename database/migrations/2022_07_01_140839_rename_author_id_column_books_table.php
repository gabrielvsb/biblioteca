<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAuthorIdColumnBooksTable extends Migration
{
    public function up(): void
    {
        Schema::table('books', function($table)
        {
            $table->renameColumn('author_id', 'id_author');
        });
    }

    public function down(): void
    {
        Schema::table('books', function($table)
        {
            $table->renameColumn('id_author', 'author_id');
        });
    }
}
