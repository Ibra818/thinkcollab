<?php

use App\Models\FormationSection;
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
        Schema::create('lesson_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('url_video');
            $table->integer('ordre');
            $table->integer('duree'); // en secondes
            $table->boolean('est_gratuit')->default(false);
            $table->timestamps();
        });

        // Schema::table('lesson_videos', function (Blueprint $table) {
        //     $table->foreignIdFor(FormationSection::class)->nullable()->constrained()->cascadeOnDelete();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_videos');
    }
};
