<?php

namespace App\Controller\Api;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class ApiUserController extends AbstractController
{


    public function __construct(
        private SerializerInterface $serializer
    )
    {

    }

    #[Route('/api/user')]
    public function getUserInfo()
    {

        return $this->json($this->getUser(), context: ['groups' => ['user']]);

    }

    #[Route('/api/register', methods: ["POST"])]
    public function setUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {

        $data = json_decode($request->getContent(), true);

        $now = new \DateTime();
        $dateOfBirth = new \DateTime($data["dateOfBirth"]);
        $age = $now->diff($dateOfBirth);
        $age = $age->y; // get his year age


        if ($age < 18) {
            return new JsonResponse("You must have at least 18 years old", 400);

        }

        if ($data["password"] != $data["confPassword"]) {
            return new JsonResponse("Passwords doesn't match", 400);
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
            return new JsonResponse("Email already exist!", 400);

        }


        return $this->json(['message' => 'Your account has been created, please check your inbox to validate your account!'], 200);
    }


    #[Route('/api/login_user', methods: ["POST"])]
    public function apiLogin(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher
        , JWTTokenManagerInterface   $JWTTokenManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = $userRepository->findOneBy(['email' => $email]);


        if (!$user || !$userPasswordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $token = $JWTTokenManager->create($user);

        $user = $this->serializer->normalize($user, null, ['groups' => ['user']]);

        return $this->json(['token' => $token, 'user' => $user]);
    }

    #[Route('/api/check_token', methods: ["POST"])]
    public function checkUser(Request $request)
    {

        $user = $this->getUser();

        if ($user) {

            $user = $this->serializer->normalize($user, null, ['groups' => ['user']]);
            return new JsonResponse($user);

        }

        return new JsonResponse(["Error" => "Invalid token"]);
    }
}
