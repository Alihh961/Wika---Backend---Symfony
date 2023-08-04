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
        if (count($value) == 1) {
            return "ROLE_USER";
        } else {


            $string = "ROLE_USER";
            for ($i = 0; $i < count($value) - 1; $i++) {
                $string .= " , " . $value[0];
            }

            return $string;
        }
    }
}
