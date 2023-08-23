<?php

namespace App\Controller\Api;

use App\Repository\NftRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiNftController extends AbstractController
{
    #[Route("api/nft" ,methods: ['GET' , 'POST'])]
    public function index(NftRepository $nftRepository)
    {
        $nfts = $nftRepository->findAll();

        return $this->json($nfts , context: ["groups"=>["nft"]]);
    }

}