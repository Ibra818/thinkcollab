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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique(); // ID unique de la transaction
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->string('provider_transaction_id')->nullable(); // ID du provider
            $table->string('provider_reference')->nullable(); // référence du provider
            $table->integer('amount'); // montant en centimes
            $table->string('currency', 3)->default('XOF');
            $table->integer('fees')->default(0); // frais en centimes
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->string('phone_number')->nullable(); // pour mobile money
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->json('provider_response')->nullable(); // réponse complète du provider
            $table->json('metadata')->nullable(); // données additionnelles
            $table->string('failure_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['provider_transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
