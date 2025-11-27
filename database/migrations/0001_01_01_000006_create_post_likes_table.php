<?php

/**
 * Blueprint for schema
 * Schema for create command
 * Migration for inheritance
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *run migrations
     */
    public function up(): void
    {
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Unique constraint: one like per user per post
            $table->unique(['post_id', 'user_id']);
            $table->index(['post_id', 'created_at']);
        });
    }

    /**
     * drop migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('post_likes');
    }
};
