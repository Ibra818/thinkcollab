<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            // TouchPoint by InTouch Methods
            [
                'name' => 'Orange Money',
                'provider' => 'touchpoint',
                'type' => 'mobile_money',
                'code' => 'om_sn',
                'currency' => 'XOF',
                'fee_percentage' => 2.00,
                'fee_fixed' => 0,
                'is_active' => true,
                'config' => [
                    'target_payment' => 'Orange Money',
                    'min_amount' => 100,
                    'max_amount' => 1000000,
                ],
                'logo_url' => '/images/payment-methods/orange-money.png',
            ],
            [
                'name' => 'Wave',
                'provider' => 'touchpoint',
                'type' => 'mobile_money',
                'code' => 'wave_sn',
                'currency' => 'XOF',
                'fee_percentage' => 1.50,
                'fee_fixed' => 0,
                'is_active' => true,
                'config' => [
                    'target_payment' => 'Wave',
                    'min_amount' => 100,
                    'max_amount' => 1000000,
                ],
                'logo_url' => '/images/payment-methods/wave.png',
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code'], 'provider' => $method['provider']],
                $method
            );
        }
    }
}
