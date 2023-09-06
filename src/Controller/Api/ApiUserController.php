<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiUserController extends AbstractController
{
    #[Route('/api/user' , name:'app_api_user')]
    public function getUserInfo(UserInterface $user)
    {

    return $this->json($this->getUser() , context: ['groups'=>['user']]);
    }
}