<?php

namespace App\Controller\Api;

use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSubCategoryController extends AbstractController
{
    #[Route('/api/sub-category', name: 'app_api_sub_category')]
    public function index(Request $request, SubCategoryRepository $subCategoryRepository): Response
    {
        $inputValue = $request->query->get("v"); // get the value sent

        if ($inputValue === "all" || $inputValue === null) {
            $subCategories = $subCategoryRepository->findAll();
        } else {
            $qb = $subCategoryRepository->getQbAll()
                ->where("s.name like :value")
                ->setParameter('value', "%" . $inputValue . "%");

            $subCategories = $qb->getQuery()->getResult();
        }

        return $this->json($subCategories, context: ["groups" => ["apiSearch"]]);
    }
}
