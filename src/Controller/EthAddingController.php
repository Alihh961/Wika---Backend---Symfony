<?php

namespace App\Controller;


use App\Entity\Eth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EthAddingController extends AbstractController{


    #[Route("set-eth-price")]
    public function setEthPrice(HttpClientInterface $httpClient , EntityManagerInterface $entityManager){

        try{
//            $response = $httpClient->request("GET" , "https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=EUR");
//            $currentPrice = $response->getContent();
//            $currentPrice = json_decode($currentPrice)->EUR;

            $currentPrice = rand(100000,130000)/100;


            $date = new \DateTime();
            $ethEntity = new Eth();

            $ethEntity->setPrice($currentPrice);
            $ethEntity->setDate($date);

            $entityManager->persist($ethEntity);
            $entityManager->flush();
            return $this->json("Data added with success!" , 200);
        }
        catch(\Exception $exception){
            return $this->json($exception , 403);
        }


    }
}