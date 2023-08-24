<?php

namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("api/eth")]
class ApiEthController extends AbstractController
{
    #[Route("/", methods: ["GET"])]
    public function index()
    {

    }
}