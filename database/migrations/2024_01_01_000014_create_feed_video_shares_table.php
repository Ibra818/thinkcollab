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
        Schema::create('feed_video_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('feed_video_id')->constrained()->onDelete('cascade');
            $table->string('platform')->nullable(); // facebook, twitter, linkedin, etc.
            $table->string('ip_address')->nullable();
            $table->timestamp('shared_at')->nullable();
            $table->timestamps();
            
            $table->index(['feed_video_id', 'platform']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_video_shares');
    }
};
