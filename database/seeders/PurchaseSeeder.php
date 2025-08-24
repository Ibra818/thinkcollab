<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\Inscription;
use App\Models\PaymentTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Achats completés avec inscriptions
        $completedPurchases = [
            [
                'user_id' => 5, // Aissatou Ndiaye
                'formation_id' => 1, // Laravel Avancé
                'montant_total' => 25000,
                'statut' => 'completed',
                'methode_paiement' => 'orange_money',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'user_id' => 6, // Mamadou Sy
                'formation_id' => 2, // React.js
                'montant_total' => 20000,
                'statut' => 'completed',
                'methode_paiement' => 'wave',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'user_id' => 7, // Khady Faye
                'formation_id' => 3, // UX/UI Design
                'montant_total' => 18000,
                'statut' => 'completed',
                'methode_paiement' => 'orange_money',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'user_id' => 8, // Ibrahima Diop
                'formation_id' => 5, // Flutter
                'montant_total' => 22000,
                'statut' => 'completed',
                'methode_paiement' => 'wave',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'user_id' => 9, // Test User
                'formation_id' => 1, // Laravel Avancé
                'montant_total' => 25000,
                'statut' => 'completed',
                'methode_paiement' => 'orange_money',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
        ];

        // Achats en attente
        $pendingPurchases = [
            [
                'user_id' => 5, // Aissatou Ndiaye
                'formation_id' => 4, // Cybersécurité
                'montant_total' => 30000,
                'statut' => 'pending',
                'methode_paiement' => null,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'user_id' => 6, // Mamadou Sy
                'formation_id' => 3, // UX/UI Design
                'montant_total' => 18000,
                'statut' => 'pending',
                'methode_paiement' => null,
                'created_at' => now()->subHours(1),
                'updated_at' => now()->subHours(1),
            ],
        ];

        // Créer les achats completés et leurs inscriptions
        foreach ($completedPurchases as $purchaseData) {
            $purchase = Purchase::create($purchaseData);

            // Créer l'inscription correspondante
            Inscription::create([
                'user_id' => $purchase->user_id,
                'formation_id' => $purchase->formation_id,
                'purchase_id' => $purchase->id,
                'date_inscription' => $purchase->created_at,
                'statut' => 'active',
                'progres' => rand(0, 100), // Progrès aléatoire
            ]);

            // Créer une transaction de paiement fictive
            PaymentTransaction::create([
                'purchase_id' => $purchase->id,
                'payment_method_id' => $purchase->methode_paiement === 'orange_money' ? 1 : 2,
                'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                'provider_transaction_id' => 'TP_' . rand(100000, 999999),
                'amount' => $purchase->montant_total,
                'fees' => $purchase->montant_total * 0.02, // 2% de frais
                'currency' => 'XOF',
                'status' => 'completed',
                'provider_response' => json_encode([
                    'status' => 'SUCCESS',
                    'message' => 'Payment completed successfully',
                ]),
                'created_at' => $purchase->created_at,
                'updated_at' => $purchase->updated_at,
            ]);
        }

        // Créer les achats en attente
        foreach ($pendingPurchases as $purchaseData) {
            Purchase::create($purchaseData);
        }
    }
}
