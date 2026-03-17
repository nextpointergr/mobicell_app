<?php

namespace App\Services;

use App\Models\Store;
use InvalidArgumentException;
use NextPointer\Pylon\Client\PylonClient;
use NextPointer\Pylon\Store\PylonStore;

class PylonManager extends \NextPointer\Pylon\Manager\PylonManager
{
    public function store(string $name): PylonStore
    {
        if (!isset($this->stores[$name])) {

            $store = Store::where('slug', $name)->first();

            if (!$store) {
                throw new InvalidArgumentException("Store [$name] not found.");
            }

            if (!$store->hasPylon()) {
                throw new InvalidArgumentException("Store [$name] has no Pylon config.");
            }

            $this->stores[$name] = new PylonStore(
                $name,
                new PylonClient($store->getPylonConfig())
            );
        }

        return $this->stores[$name];
    }
}
