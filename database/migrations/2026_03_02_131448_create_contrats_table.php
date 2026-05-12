<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('contrats', function (Blueprint $table) {

        $table->id();

        $table->string('client');

        $table->string('projet');

        $table->date('date_signature');

        $table->string('document');

        $table->string('avenant')->nullable();

        $table->timestamps();

    });
}
};
