<?php

namespace Tests;

use App\CommissionCalculator;
use App\Services\BinProvider;
use App\Services\CurrencyRateProvider;
use PHPUnit\Framework\TestCase;

final class CommissionCalculatorTest extends TestCase
{
    public function testCalculateCommission()
    {
        $countryCode = ($faker = \Faker\Factory::create())->randomElement(['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK']);

        $binProvider = $this->createMock(BinProvider::class);
        $binProvider->method('getBinData')->willReturn((object)['country' => (object)['alpha2' => $countryCode]]);

        $currencyRateProvider = $this->createMock(CurrencyRateProvider::class);
        $currencyRateProvider->method('getCurrencyRate')->willReturn(1.5);

        $calculator = new CommissionCalculator($binProvider, $currencyRateProvider);

        $transaction = ['bin' => $faker->numerify('########'), 'amount' => $faker->randomFloat(2, 1, 1000), 'currency' => $faker->randomElement(['EUR', 'USD', 'JPY'])];
        $commission = $calculator->calculateCommission($transaction);

        $expectedCommission = ceil(($transaction['amount'] / 1.5) * 0.01 * 100) / 100;
        $this->assertEquals($expectedCommission, $commission);
    }
}