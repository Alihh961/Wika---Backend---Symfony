<?php

namespace App\Controller;

use App\Repository\EthRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{

    public function __construct(private HttpClientInterface $httpClient)
    {
    }



    #[Route('/', name: 'app_home')]
    public function index( Security $security ): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }
}
