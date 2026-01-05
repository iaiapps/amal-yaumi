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
        Schema::create('mutabaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal');
            $table->json('data'); // Dynamic data based on mutabaah_items
            $table->timestamps();
            
            // Indexes
            $table->index('student_id');
            $table->index('tanggal');
            $table->index(['student_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutabaahs');
    }
};
