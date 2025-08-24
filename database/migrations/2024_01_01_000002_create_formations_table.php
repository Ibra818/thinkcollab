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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->integer('prix'); // en centimes
            $table->integer('duree_estimee')->nullable(); // durée en minutes
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance'])->default('debutant');
            $table->string('langue', 5)->default('fr');
            $table->enum('statut', ['brouillon', 'publie'])->default('brouillon');
            $table->string('image_couverture')->nullable();
            $table->string('video_preview')->nullable();
            $table->boolean('certificat_disponible')->default(false);
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
