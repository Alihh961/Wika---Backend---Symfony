<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestApiController extends AbstractController
{
    #[Route('/api/test_connection', name: 'app_test_api')]
    public function index(): Response
    {
//        return $this->render('test_api/index.html.twig', [
//            'controller_name' => 'TestApiController',
//        ]);

        $user =$this->getUser();

//        dd($user);

        if($user === null){
            return $this->json("Not Connected.");
        }else{
            return $this->json("connected as ". $user->getEmail());
        }
        
    }
}
