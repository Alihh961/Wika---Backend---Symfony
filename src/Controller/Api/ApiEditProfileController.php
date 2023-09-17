<?php


namespace App\Controller\Api;




use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api")]
class ApiEditProfileController extends AbstractController{

    #[Route("/editprofile" , methods : ["POST"])]
    public function edit(Request $request , UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher){

        $data = json_decode($request->getContent() , true);
        $idUser = $data["id"];




        $user = $userRepository->find($idUser);
        $user->setFirstName($data["firstName"]);
        $user->setLastName($data["lastName"]);

        $newPassword = $data["password"];
        $newHashedPassword = $userPasswordHasher->hashPassword($user , $newPassword);
        $user->setPassword($newHashedPassword);

        dd($user);

    }
}