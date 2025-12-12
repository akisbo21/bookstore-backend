<?php

namespace App\Http\Controllers;

use App\Services\ExchangeRateService;

class ExchangeRateController extends Controller
{
    public function fetchEurHuf()
    {
        return app(ExchangeRateService::class)->fetchEurHuf();
    }
}
