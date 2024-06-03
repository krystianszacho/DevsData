<?php

namespace App\Services;

class BinProvider
{
    private array $cache = [];

    public function getBinData(string $bin)
    {
        if (!isset($this->cache[$bin])) {
            sleep(1);
            $binResults = file_get_contents('https://lookup.binlist.net/' . $bin);
            if (!$binResults) {
                throw new \Exception('Error retrieving BIN data');
            }

            $this->cache[$bin] = json_decode($binResults);
        }

        return $this->cache[$bin];
    }
}
