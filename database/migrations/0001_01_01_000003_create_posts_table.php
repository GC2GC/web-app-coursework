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
     * run migrations
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->integer('views_count')->default(0)->index();
            $table->integer('likes_count')->default(0)->index();
            $table->integer('comments_count')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * drop migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
