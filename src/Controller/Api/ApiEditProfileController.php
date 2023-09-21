<?php


namespace App\Controller\Api;




use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api")]
class ApiEditProfileController extends AbstractController{

    #[Route("/editprofile" , methods : ["POST"])]
    public function edit(Request $request , UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher,
    EntityManagerInterface $entityManager){


        $data = json_decode($request->getContent() , true);

        $idUser = $data["id"];
        $firstName = $data["firstName"];
        $lastName =$data["lastName"];
        $receivedCurrentPassword = $data["currentPassword"];
        $newPassword = $data["newPassword"];
        if( !$firstName || !$lastName ||  !$receivedCurrentPassword || !$newPassword){
            return new JsonResponse("All fields are required", 406);
        }


        $user = $userRepository->find($idUser);

        // if problem of user
        if(!$user){
           return new JsonResponse("User Not Found , something wrong!" , 404);
        }


        //if the current password is equal to that stored in database
        if($userPasswordHasher->isPasswordValid($user , $receivedCurrentPassword)){
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $newHashedPassword = $userPasswordHasher->hashPassword($user , $newPassword);
            $user->setPassword($newHashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse("Informations Updated Successfully" , 200);
        }

        // if there is another errors like passwords are not equal
        return new JsonResponse("Current Password Error" , 401);


    }
}