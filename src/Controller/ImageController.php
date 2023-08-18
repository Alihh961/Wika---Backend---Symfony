<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/image')]
class ImageController extends AbstractController
{

    public function __construct(
       private PaginatorInterface $paginator
    )
    {
    }

    #[Route('/', name: 'app_image_index', methods: ['GET'])]
    public function index(ImageRepository $imageRepository , Request $request): Response
    {
        $allImages = $imageRepository->findAll();
        $pagination = $this->paginator->paginate(
            $allImages,
            $request->query->getInt("page" ,1) ,
            10
        );
        return $this->render('image/index.html.twig', [
            'images' => $pagination,
        ]);
    }


    #[Route('/{id}', name: 'app_image_show', methods: ['GET'])]
    public function show(Image $image): Response
    {
        return $this->render('image/show.html.twig', [
            'image' => $image,
        ]);
    }


}
