<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')
                  ->constrained('restaurants')
                  ->onDelete('cascade');
            $table->string('name');                    
            $table->string('image')->nullable();      
            $table->text('description')->nullable();   
            $table->string('category');               
            $table->decimal('price', 12, 2);           
            $table->boolean('is_available')->default(true); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_menus');
    }
};