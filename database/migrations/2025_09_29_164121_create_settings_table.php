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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Owner of these settings (per-user settings)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Privacy settings
            $table->boolean('public_profile')->default(true);
            $table->boolean('email_visible')->default(false);
            $table->boolean('show_online_status')->default(true);
            $table->boolean('data_sharing')->default(false);

            // Notification settings
            $table->boolean('notify_new_collaborations')->default(true);
            $table->boolean('notify_messages')->default(true);
            $table->boolean('notify_project_updates')->default(true);
            $table->boolean('notify_push')->default(false);

            // Optional UI preferences (reserved for future use)
            $table->string('language', 8)->default('fr');
            $table->string('theme', 16)->default('light');
            $table->unsignedSmallInteger('items_per_page')->default(12);

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
