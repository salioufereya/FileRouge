<?php

use App\Http\Controllers\AnneeClasse;
use App\Models\Classe;
use App\Models\Cours;
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
        Schema::create('cours_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cours::class);
            $table->float('nbr_heures')->nullable(false);
            $table->foreignIdFor(AnneeClasse::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours_classes');
    }
};
