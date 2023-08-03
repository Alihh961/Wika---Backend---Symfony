<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSubCategoryController extends AbstractController
{
    #[Route('/api/sub-category', name: 'app_api_sub_category')]
    public function index(): Response
    {

        return $this->json('toto');
    }
}
