<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('canonical_url')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('post_details', function (Blueprint $table) {
            $table->uuid('post_id')->primary();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();

            $table->uuid('platform_id')->nullable();
            $table->foreign('platform_id')->references('id')->on('platforms')->cascadeOnDelete();

            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
