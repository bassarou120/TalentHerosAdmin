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
        Schema::table('campagnes', function (Blueprint $table) {
            //
            $table->integer('publication_gagnante')->nullable();
            $table->integer('nbr_participant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campagnes', function (Blueprint $table) {
            //
        });
    }
};