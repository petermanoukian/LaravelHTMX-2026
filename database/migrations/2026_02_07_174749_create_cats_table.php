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
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('des')->nullable();   // short description
            $table->longtext('dess')->nullable();    // long description
            $table->string('img')->nullable();   // image
            $table->string('img2')->nullable();  // thumbnail
            $table->string('filer')->nullable(); // file
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
