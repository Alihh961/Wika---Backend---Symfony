<?php

namespace App\Controller\Api;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use Date;
class ApiUserController extends AbstractController
{
    #[Route('/api/user', name: 'app_api_user')]
    public function getUserInfo(UserInterface $user)
    {

        return $this->json($this->getUser(), context: ['groups' => ['user']]);
    }

    #[Route('/api/user/add' ,name: 'app_api_user_add')]
    public function setUser(Request $request)
    {
        $data = json_decode($request->getContent(),true);

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


        dd($user);

        return new JsonResponse($u);
    }
}