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
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('viewed_date');
            $table->timestamps();
            // Removed unique constraint to allow multiple views per IP per day
            $table->index(['post_id', 'viewed_date']);
            $table->index(['ip_address', 'viewed_date']);
        });
    }



    /**
     * drop migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};
