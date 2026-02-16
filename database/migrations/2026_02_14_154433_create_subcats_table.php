<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcats', function (Blueprint $table) {
            $table->id();

            // Foreign key to cats
            $table->foreignId('catid')
                  ->constrained('cats')
                  ->onDelete('cascade');

            $table->string('name');
            $table->text('des')->nullable();    // short description
            $table->longText('dess')->nullable(); // long description
            $table->string('img')->nullable();   // image
            $table->string('img2')->nullable();  // thumbnail
            $table->string('filer')->nullable(); // file
            $table->timestamps();

            // Unique constraint: cat_id + name
            $table->unique(['catid', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcats');
    }
};
