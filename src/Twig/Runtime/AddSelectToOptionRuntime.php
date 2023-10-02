<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class AddSelectToOptionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function checkSubCategoryName($value)
    {
        return '<option>"lkef"<option>';
    }
}
