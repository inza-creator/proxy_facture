<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facture_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facture_id')->constrained('factures')->cascadeOnDelete();
            $table->text('description');
            $table->decimal('quantite', 12, 2);
            $table->decimal('prix_unitaire', 15, 2);
            $table->decimal('montant_ht', 15, 2);
            $table->timestamps();
        });

        $factures = DB::table('factures')->select('id', 'objet', 'montant')->get();
        foreach ($factures as $f) {
            DB::table('facture_lignes')->insert([
                'facture_id' => $f->id,
                'description' => $f->objet ?? 'Prestation',
                'quantite' => 1,
                'prix_unitaire' => $f->montant,
                'montant_ht' => $f->montant,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('facture_lignes');
    }
};
