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
            $table->string('puasa');
            $table->string('subuh');
            $table->string('dhuhur');
            $table->string('ashar');
            $table->string('magrib');
            $table->string('isya');
            $table->string('dhuha');
            $table->string('tarawih');
            $table->string('tahajud');
            $table->string('tilawah');
            $table->string('infaq');
            $table->string('birrul');
            $table->timestamps();
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
