<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{

    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        $response = $this->httpClient->request("GET" , "https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=USD,JPY,EUR");
        $prix = $response->getContent();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'prix' => (json_decode($prix))->EUR
        ]);
    }
}
