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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('generic_name');
            $table->string('brand_name')->nullable();
            $table->string('drug_class')->nullable();
            $table->string('dosage_form')->nullable();
            $table->string('strength')->nullable();
            $table->text('description')->nullable();
            $table->text('contraindications')->nullable();
            $table->text('warnings')->nullable();
            $table->text('storage_information')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->index('generic_name');
            $table->index('brand_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
