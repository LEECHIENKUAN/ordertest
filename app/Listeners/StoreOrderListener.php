<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreOrderListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Log::info('StoreOrderListener triggered', ['data' => $event->data]);

        $data = $event->data;
        $data = $event->data;
        $table = match ($data['currency']) {
            'TWD' => 'orders_twd',
            'USD' => 'orders_usd',
            default => null,
        };
        if ($table) {
            DB::table($table)->insert(
                [
                'order_id' => $data['id'],
                'name' => $data['name'],
                'address' => json_encode($data['address']),
                'price' => $data['price'],
                'created_at' => now(),
                'updated_at' => now(),
                ]
            );
        }
    }
}
