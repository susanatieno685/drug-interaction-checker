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
        Schema::create('drug_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drug_a_id')->constrained('drugs')->restrictOnDelete();
            $table->foreignId('drug_b_id')->constrained('drugs')->restrictOnDelete();
            $table->foreignId('interaction_severity_id')->constrained('interaction_severities')->restrictOnDelete();
            $table->text('mechanism');
            $table->text('clinical_effect');
            $table->text('management');
            $table->text('monitoring_advice')->nullable();
            $table->string('evidence_level')->nullable();
            $table->text('reference')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->unique(['drug_a_id', 'drug_b_id']);
            $table->index(['drug_a_id', 'drug_b_id']);
            $table->index('interaction_severity_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_interactions');
    }
};
