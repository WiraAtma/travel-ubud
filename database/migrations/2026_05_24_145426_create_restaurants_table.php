<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_cover')->nullable();
            $table->string('address');
            $table->string('phone', 20);
            $table->string('category');                      
            $table->decimal('start_price', 12, 2);          
            $table->longText('description');                 
            $table->time('open_time');                       
            $table->time('close_time');                      
            $table->text('notes')->nullable();               
            $table->decimal('rating', 3, 1)->default(0.0);  // 1 - 5
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
        Schema::dropIfExists('restaurants');
    }
};