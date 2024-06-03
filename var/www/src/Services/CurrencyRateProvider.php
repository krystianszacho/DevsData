<?php

namespace App\Services;

class CurrencyRateProvider
{
    private array $cache = [];

    public function getCurrencyRate(string $currency): float
    {
        if (!isset($this->cache[$currency])) {
            sleep(1);

            $rateData = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$currency];
            $this->cache[$currency] = $currency == 'EUR' || $rateData == 0 ? 1 : $rateData;
        }

        return $this->cache[$currency];
    }
}
