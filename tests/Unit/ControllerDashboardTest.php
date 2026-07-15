<?php

namespace Tests\Unit;

use App\Http\Controllers\Controller;
use Tests\TestCase;

class ControllerDashboardTest extends TestCase
{
    public function test_daily_revenue_stats_include_required_keys(): void
    {
        $controller = new Controller();
        $stats = $controller->getDailyRevenueStats(3);

        $this->assertCount(3, $stats);
        $this->assertArrayHasKey('date', $stats[0]);
        $this->assertArrayHasKey('label', $stats[0]);
        $this->assertArrayHasKey('revenue', $stats[0]);
        $this->assertArrayHasKey('orders', $stats[0]);
        $this->assertIsString($stats[0]['date']);
        $this->assertIsString($stats[0]['label']);
        $this->assertIsNumeric($stats[0]['revenue']);
        $this->assertIsInt($stats[0]['orders']);
    }

    public function test_employee_revenue_stats_include_required_keys(): void
    {
        $controller = new Controller();
        $stats = $controller->getEmployeeRevenueStats();

        $this->assertIsArray($stats);
        if (!empty($stats)) {
            $this->assertArrayHasKey('name', $stats[0]);
            $this->assertArrayHasKey('revenue', $stats[0]);
            $this->assertArrayHasKey('orders', $stats[0]);
            $this->assertIsString($stats[0]['name']);
            $this->assertIsNumeric($stats[0]['revenue']);
            $this->assertIsInt($stats[0]['orders']);
        }
    }

    public function test_category_distribution_stats_include_required_keys(): void
    {
        $controller = new Controller();
        $stats = $controller->getCategoryDistributionStats();

        $this->assertIsArray($stats);
        if (!empty($stats)) {
            $this->assertArrayHasKey('name', $stats[0]);
            $this->assertArrayHasKey('count', $stats[0]);
            $this->assertIsString($stats[0]['name']);
            $this->assertIsInt($stats[0]['count']);
        }
    }
}
