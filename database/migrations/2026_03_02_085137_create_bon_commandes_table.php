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
    Schema::create('bon_commandes', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('demande_id');

        $table->string('client');

        $table->string('fichier');

        $table->date('date_reception');

        $table->timestamps();

        $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');

    });
}
};
