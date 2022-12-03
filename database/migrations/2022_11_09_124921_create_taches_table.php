<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('description')->lenght(300);
            $table->string('status')->lenght(50);
            $table->string('maturity_date');
            $table->string('resolution_degree')->nullable()->lenght(50);
            $table->unsignedBigInteger('departement_solving_id');
            $table->foreign('departement_solving_id')->references('id')->on('departements')->onUpdate(\DB::raw('NO ACTION'));
            $table->string('incident_number', 15);
            $table->foreign('incident_number')->references('number')->on('incidents')->onDelete('cascade');
            $table->date('created_at');
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taches');
    }
}
