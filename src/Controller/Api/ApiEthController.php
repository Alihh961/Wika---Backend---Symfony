<?php

namespace App\Controller\Api;


use App\Repository\EthRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route("api/")]
class ApiEthController extends AbstractController
{
    #[Route("eth", methods: ["GET"])]
    public function index(EthRepository $ethRepository)
    {
        $ethValues = $ethRepository->findAll();

        $ethValues = $ethRepository->createQueryBuilder("e")
            ->orderBy("e.date" , "DESC")
            ->setMaxResults(7)
            ->getQuery()
            ->getResult();

        return $this->json($ethValues , context: ["groups"=>["eth"]]);
    }
}