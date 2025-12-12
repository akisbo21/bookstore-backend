<?php

namespace App\Services;

use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function fetchEurHuf(): array
    {
        $today = now()->toDateString();

        $existing = ExchangeRate::where('base_currency', 'EUR')
            ->where('quote_currency', 'HUF')
            ->whereDate('fetched_at', $today)
            ->latest('fetched_at')
            ->first();

        if ($existing) {
            return $existing->toArray();
        }

        $response = Http::get('https://api.exchangerate-api.com/v4/latest/EUR');
        $rate = $response->json('rates.HUF');

        $row = ExchangeRate::create([
            'base_currency' => 'EUR',
            'quote_currency' => 'HUF',
            'rate' => $rate,
            'fetched_at' => now(),
            'source' => 'exchangerate-api',
        ]);

        return $row->toArray();
    }
}
