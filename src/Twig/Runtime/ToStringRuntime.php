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

            if(in_array("ROLE_SUPER_ADMIN" , $value)){
                return "SUPER_ADMIN";
            }else if (in_array("ROLE_ADMIN" ,$value)){
                return "ADMIN";
            }else{
                return "USER";
            }



    }
}
