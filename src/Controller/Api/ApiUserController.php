<?php

namespace App\Controller\Api;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiUserController extends AbstractController
{
    #[Route('/api/user')]
    public function getUserInfo()
    {

        return $this->json($this->getUser(), context: ['groups' => ['user']]);

    }

    #[Route('/api/register', methods : ["POST"])]
    public function setUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);


        if ($data["password"] != $data["confPassword"]) {
            throw new \Exception("Password doesn't match!");

        }


        $user = new User();
        $user->setFirstName($data["firstName"]);
        $user->setLastName($data["lastName"]);
        $user->setEmail($data["email"]);
        $user->setGender($data["gender"]);
        $user->setDateOfBirth(new \DateTime($data['dateOfBirth']));

        $address = new Address();
        $address->setDepartment($data["address"]["department"]);
        $address->setPath($data["address"]["path"]);
        $address->setMunicipality($data["address"]["municipality"]);
        $address->setBuildingNumber($data["address"]["buildingNumber"]);
        $address->setPostCode($data["address"]["postCode"]);
        $address->setRegion($data["address"]["region"]);

        $user->setAddress($address);

        //we hash the password received
        $passwordReceived = $data["password"];
        $hashedPassword = $userPasswordHasher->hashPassword(
            $user,
            $passwordReceived
        );

        $user->setPassword($hashedPassword);
        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Exception $exception) {
            throw new HttpException(400, "User Already Exists");
        }


        return $this->json(['message' => 'Your account has been created, please check your inbox to validate your account!'], 200);
    }


}