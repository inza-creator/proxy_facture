<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('relances', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('facture_id');

        $table->date('date_relance');

        $table->string('niveau_relance'); 
        // relance 1, relance 2, mise en demeure

        $table->text('commentaire')->nullable();

        $table->timestamps();

        $table->foreign('facture_id')->references('id')->on('factures')->onDelete('cascade');

    });
}
};
