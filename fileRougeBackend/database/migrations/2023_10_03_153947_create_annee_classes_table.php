<?php

use App\Models\Annee;
use App\Models\Classe;
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
        Schema::create('annee_classes', function (Blueprint $table) {
            $table->id();
            $table->integer('effectif');
            $table->foreignIdFor(Annee::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Classe::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annee_classes');
    }
};
