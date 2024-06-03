<?php

namespace App;

use App\Services\BinProvider;
use App\Services\CurrencyRateProvider;

class CommissionCalculator
{
    private BinProvider $binProvider;
    private CurrencyRateProvider $currencyRateProvider;

    public function __construct(BinProvider $binProvider, CurrencyRateProvider $currencyRateProvider)
    {
        $this->binProvider = $binProvider;
        $this->currencyRateProvider = $currencyRateProvider;
    }

    public function calculateCommission(array $transaction): float
    {
        $binResults = $this->binProvider->getBinData($transaction['bin']);
        $isEu = $this->isEu($binResults->country->alpha2 ?? '');

        $rate = $this->currencyRateProvider->getCurrencyRate($transaction['currency']);
        $amountFixed = $transaction['amount'] / ($rate ?: 1);

        return ceil($amountFixed * ($isEu ? 0.01 : 0.02) * 100) / 100;
    }

    private function isEu(string $countryCode): bool
    {
        $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];

        return in_array($countryCode, $euCountries);
    }
}