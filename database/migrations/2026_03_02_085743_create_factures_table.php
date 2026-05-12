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
    Schema::create('factures', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('bon_commande_id');

        $table->string('numero_facture');

        $table->string('client');

        $table->string('objet');

        $table->decimal('montant', 10,2);

        $table->decimal('tva', 10,2)->nullable();

        $table->string('type_facture'); 
        // proforma ou definitive

        $table->date('date_facture');

        $table->string('statut')->default('impayée');

        $table->timestamps();

        $table->foreign('bon_commande_id')
        ->references('id')
        ->on('bon_commandes')
        ->onDelete('cascade');

    });
}
};
