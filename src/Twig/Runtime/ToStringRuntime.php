<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ToStringRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {

    }

    public function ArrayToString(array $value)
    {

        return $value[0];

    }
}
