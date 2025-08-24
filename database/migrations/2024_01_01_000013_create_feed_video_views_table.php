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
        Schema::create('feed_video_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('feed_video_id')->constrained()->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();
            
            // Permettre plusieurs vues par utilisateur mais tracker l'IP pour les anonymes
            $table->index(['feed_video_id', 'user_id']);
            $table->index(['feed_video_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_video_views');
    }
};
