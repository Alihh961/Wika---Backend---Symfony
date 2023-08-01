<?php

namespace App\Twig\Runtime;

use App\Entity\Eth;
use App\Repository\EthRepository;
use Twig\Extension\RuntimeExtensionInterface;

class EthExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private EthRepository $ethRepository
    )
    {
        // Inject dependencies if needed
    }

    public function ethToEuro($value)
    {
        $eth = new Eth();
        $totalEuro = $value ;

        return $totalEuro;
    }
}
