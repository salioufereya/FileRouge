<?php

use App\Models\Filiere;
use App\Models\Module;
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
        // Schema::create('module_filieres', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignIdFor(Module::class);
        //     $table->foreignIdFor(Filiere::class);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_filieres');
    }
};
