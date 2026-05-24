<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_cover')->nullable();
            $table->longText('content');
            $table->string('location');
            $table->string('categories'); 
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->unsignedInteger('rating_count')->default(0); 
            $table->boolean('banned')->default(false);
            $table->foreignId('id_author')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};