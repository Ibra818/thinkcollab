<?php

namespace App\Listeners;

use App\Models\Inscription;
use App\Events\PurchaseStatusUpdated as PurchaseStatusUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PurchaseStatusUpdated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(PurchaseStatusUpdatedEvent $event): void
    {
        $purchase = $event->purchase;

        // Si le paiement est confirmé, créer une inscription
        if ($purchase->status === 'paid') {
            Inscription::firstOrCreate([
                'user_id' => $purchase->user_id,
                'formation_id' => $purchase->formation_id,
            ], [
                'date_inscription' => now(),
                'statut' => 'en_cours',
            ]);
        }
    }
}
