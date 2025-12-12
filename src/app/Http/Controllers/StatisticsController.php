<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;

class StatisticsController extends Controller
{
    private StatisticsService $service;

    public function __construct(StatisticsService $service)
    {
        $this->service = $service;
    }

    public function expensiveBooks()
    {
        return $this->service->expensiveBooks();
    }

    public function popularCategories()
    {
        return $this->service->popularCategories();
    }

    public function topFantasyAndSciFi()
    {
        return $this->service->topFantasyAndSciFi();
    }
}
