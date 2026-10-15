<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_interaction_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_a_id')->constrained('drugs')->restrictOnDelete();
            $table->foreignId('drug_b_id')->constrained('drugs')->restrictOnDelete();
            $table->foreignId('drug_interaction_id')->nullable()->constrained('drug_interactions')->nullOnDelete();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_interaction_checks');
    }
};
