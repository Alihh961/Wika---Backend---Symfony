<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NftApiController extends AbstractController
{
    #[Route('/nft/api', name: 'app_nft_api')]
    public function index(): Response
    {
        return $this->render('nft_api/index.html.twig', [
            'controller_name' => 'NftApiController',
        ]);
    }
}
