<?php

namespace App\Controller;

use App\Entity\Audio;
use App\Entity\Image;
use App\Entity\Nft;
use App\Entity\Video;
use App\Form\EditNftFormType;
use App\Form\NftType;
use App\Repository\ImageRepository;
use App\Repository\NftRepository;
use App\Repository\UserRepository;
use App\Service\CreateMediaService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/nft')]
class NftController extends AbstractController
{


    public function __construct(
        private CreateMediaService $createMediaService,
        private PaginatorInterface $paginator
    )
    {
    }

    #[Route('/', name: 'app_nft_index', methods: ['GET'])]
    public function index(NftRepository $nftRepository, Request $request): Response
    {
        $nfts = $nftRepository->findAll();
        $pagination = $this->paginator->paginate(
            $nfts,
            $request->query->getInt("page", 1),
            7
        );

        return $this->render('nft/index.html.twig', [
            'nfts' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_nft_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NftRepository $nftRepository, SluggerInterface $slugger, UserRepository $userRepository): Response
    {
        $nft = new Nft();

        $form = $this->createForm(NftType::class, $nft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get("file")->getData();
            $imageDescription = $form->get('description')->getData();
            $imageName = $form->get('name')->getData();

            if ($file) {
                $mediaEntity = $this->createMediaService->createMediaFromUploadFile($file, $imageDescription, $imageName);
                $reflectionClass = new \ReflectionClass($mediaEntity);


                if ($reflectionClass->getName() === Image::class) {
                    $nft->setImage($mediaEntity);
                } else if ($reflectionClass->getName() === Video::class) {
                    $nft->setVideo($mediaEntity);
                } else if ($reflectionClass->getName() === Audio::class) {
                    $nft->setAudio($mediaEntity);
                }
            }


            $nftRepository->save($nft, true);

            //TODO change this
            $users = $nft->getUsers();
            foreach ($users as $user) {
                $user->addNft($nft);
                $userRepository->save($user, true);
            }


            return $this->redirectToRoute('app_nft_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft/new.html.twig', [
            'nft' => $nft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_show', methods: ['GET'])]
    public function show(Nft $nft): Response
    {
        return $this->render('nft/show.html.twig', [
            'nft' => $nft,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nft_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NftRepository $nftRepository, Nft $nft, ImageRepository $imageRepository): Response
    {
        $imageEntity = $nft->getImage();
        $description = $imageEntity->getDescription();
        $nftPrice = $nft->getPrice();

        $form = $this->createForm(EditNftFormType::class, null,[
            "description"=>$description ,
                "price"=>$nftPrice
            ]
        );
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $price = $form->get('price')->getData();
            $nft->setPrice($price);

            $description = $form->get('description')->getData();
            $imageEntity->setDescription($description);


            $imageRepository->save($imageEntity, true);
            $nftRepository->save($nft, true);

            return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft/edit.html.twig', [
            "nft" => $nft,
            'nftEditForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_delete', methods: ['POST'])]
    public function delete(Request $request, Nft $nft, NftRepository $nftRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $nft->getId(), $request->request->get('_token'))) {
            $nftRepository->remove($nft, true);
        }

        return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
    }
}
