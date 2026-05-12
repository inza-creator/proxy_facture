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
    Schema::create('parametres', function (Blueprint $table) {
        $table->id();
        $table->string('nom_entreprise')->nullable();
        $table->string('logo')->nullable();
        $table->string('adresse')->nullable();
        $table->string('telephone')->nullable();
        $table->string('email')->nullable();
        $table->text('conditions_paiement')->nullable();
        $table->timestamps();
    });
}
};
