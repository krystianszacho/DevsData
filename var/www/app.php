<?php

require __DIR__ . '/vendor/autoload.php';

use App\CommissionCalculator;
use App\Services\BinProvider;
use App\Services\CurrencyRateProvider;

$binProvider = new BinProvider();
$currencyRateProvider = new CurrencyRateProvider();
$calculator = new CommissionCalculator($binProvider, $currencyRateProvider);

$transactions = json_decode(file_get_contents($argv[1]), true);

$results = array_map(function ($transaction) use ($calculator) {
    try {
        return $calculator->calculateCommission($transaction);
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}, $transactions);

echo implode("\n", $results);