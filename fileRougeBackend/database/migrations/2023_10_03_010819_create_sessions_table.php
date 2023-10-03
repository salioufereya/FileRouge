<?php

use App\Models\CoursClasse;
use App\Models\Salle;
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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->dateTime('heure_debut');
            $table->dateTime('heure_fin');
            $table->string('etat')->default('enAttente');
            $table->foreignIdFor(Salle::class);
            $table->foreignIdFor(CoursClasse::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
