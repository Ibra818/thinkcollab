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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Orange Money, Wave, Carte Bancaire
            $table->string('provider'); // TouchPoint, PayTech, PayDunya
            $table->string('type'); // mobile_money, card, bank_transfer
            $table->string('code')->unique(); // om_sn, wave_sn, card_visa
            $table->string('currency', 3)->default('XOF');
            $table->decimal('fee_percentage', 5, 2)->default(0); // 2.50
            $table->integer('fee_fixed')->default(0); // frais fixe en centimes
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable(); // configuration spécifique au provider
            $table->string('logo_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
