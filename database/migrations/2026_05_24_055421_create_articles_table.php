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
        Schema::create('articles', function (Blueprint $table) {
           $table->id();
            $table->string('title');
            $table->string('image_cover')->nullable();
            $table->longText('content');           
            $table->foreignId('id_author')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();                  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
