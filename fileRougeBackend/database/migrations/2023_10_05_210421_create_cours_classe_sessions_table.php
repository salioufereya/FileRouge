<?php

use App\Models\CoursClasse;
use App\Models\Session;
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
        Schema::create('cours_classe_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Session::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(CoursClasse::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours_classe_sessions');
    }
};
