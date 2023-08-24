<?php

namespace App\Controller\Api;

use App\Repository\NftRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiNftController extends AbstractController
{
    #[Route("api/nft", methods: ['GET', 'POST'])]
    public function bySlug(NftRepository $nftRepository, Request $request)
    {
        $subCategoryName = $request->query->get("v") ? str_replace("-", " ", $request->query->get("v")) : "";
        $orderBy = $request->query->get("o") ? str_replace("-", " ", $request->query->get("o")) : "";

        if ($subCategoryName === "all" || $subCategoryName === "") { // selecting all nft if no para set or set to all for subcategories
            if ($orderBy == "asc" || $orderBy == "desc") { // if an order by is specified

                $nfts = $nftRepository->findAllBySubCategoryName()
                    ->orderBy("n.createdAt", $orderBy)
                    ->getQuery()
                    ->getResult();
            } else { // if no order by is specified
                $nfts = $nftRepository->findAll();
            }
        } else { //selecting nft of certian subCAtegory
            if ($orderBy == "asc" || $orderBy == "desc") { // if an order by is specified
                $nfts = $nftRepository->findBySubCategoryName($subCategoryName)
                    ->orderBy("n.createdAt", $orderBy)
                    ->getQuery()
                    ->getResult();
            } else { // if no order by is specified
                $nfts = $nftRepository->findBySubCategoryName($subCategoryName)
                    ->getQuery()
                    ->getResult();
            }

        }


        if (count($nfts) > 0) { // avoiding passing wrong parameters in url
            return $this->json($nfts, context: ["groups" => ["nft"]]);

        }
        return $this->json("No results found for this SubCategory");


    }
}