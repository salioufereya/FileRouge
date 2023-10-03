<?php

use App\Models\AnneeClasse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cours_classes', function (Blueprint $table) {
            $table->foreignIdFor(AnneeClasse::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours_classes', function (Blueprint $table) {
            //
        });
    }
};
