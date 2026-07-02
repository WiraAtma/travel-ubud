<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->index(['banned', 'rating'], 'idx_destinations_banned_rating');
            $table->index('created_at', 'idx_destinations_created_at');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->index(['banned', 'rating'], 'idx_hotels_banned_rating');
            $table->index('created_at', 'idx_hotels_created_at');
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->index(['banned', 'rating'], 'idx_restaurants_banned_rating');
            $table->index('created_at', 'idx_restaurants_created_at');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->index('created_at', 'idx_articles_created_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('created_at', 'idx_users_created_at');
        });

        Schema::table('company_requests', function (Blueprint $table) {
            $table->index('status', 'idx_company_requests_status');
            $table->index('field', 'idx_company_requests_field');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropIndex('idx_destinations_banned_rating');
            $table->dropIndex('idx_destinations_created_at');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropIndex('idx_hotels_banned_rating');
            $table->dropIndex('idx_hotels_created_at');
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropIndex('idx_restaurants_banned_rating');
            $table->dropIndex('idx_restaurants_created_at');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('idx_articles_created_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_created_at');
        });

        Schema::table('company_requests', function (Blueprint $table) {
            $table->dropIndex('idx_company_requests_status');
            $table->dropIndex('idx_company_requests_field');
        });
    }
};