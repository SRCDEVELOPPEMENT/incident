<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->string('number', 15)->primary()->unique();
            $table->string('description')->lenght(900);
            $table->date('closure_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->lenght(10);
            $table->string('cause')->lenght(900);
            $table->string('motif_annulation')->lenght(900)->nullable();
            $table->unsignedBigInteger('proces_id')->nullable();
            $table->foreign('proces_id')->references('id')->on('pros')->onUpdate('cascade')->onDelete(\DB::raw('NO ACTION'));
            $table->string('perimeter')->lenght(900)->nullable();
            $table->string('priority')->lenght(10)->nullable();
            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('incidents');
    }
}
