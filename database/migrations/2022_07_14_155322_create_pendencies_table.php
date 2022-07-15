<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendencies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Loan::class, 'id_loan');
            $table->string('status')->default('A');
            $table->decimal('fine_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendencies');
    }
}
