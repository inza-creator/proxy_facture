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
        Schema::table('relances', function (Blueprint $table) {
            $table->string('motif_relance')->nullable()->after('date_relance');
        });
        \DB::statement('UPDATE relances SET motif_relance = niveau_relance WHERE motif_relance IS NULL');
        Schema::table('relances', function (Blueprint $table) {
            $table->dropColumn('niveau_relance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relances', function (Blueprint $table) {
            $table->string('niveau_relance')->nullable()->after('date_relance');
        });
        \DB::statement('UPDATE relances SET niveau_relance = motif_relance WHERE niveau_relance IS NULL');
        Schema::table('relances', function (Blueprint $table) {
            $table->dropColumn('motif_relance');
        });
    }
};
