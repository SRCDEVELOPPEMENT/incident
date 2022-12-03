<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->string('number', 5)->primary()->unique();
            $table->string('title')->lenght(50);
            $table->string('maturity_date');
            $table->string('status')->lenght(50);
            $table->unsignedBigInteger('tache_id');
            $table->foreign('tache_id')->references('id')->on('taches')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('service_requests');
    }
}
