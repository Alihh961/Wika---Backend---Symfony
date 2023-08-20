<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SearchFormType;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sub_category')]
class SubCategoryController extends AbstractController
{

    public function __construct(
        private PaginatorInterface $paginator
    )
    {
    }

    #[Route('/', name: 'app_sub_category_index', methods: ['GET', 'POST'])]
    public function index(SubCategoryRepository $subCategoryRepository, Request $request): Response
    {
        $subCategories = $subCategoryRepository->findAll();


        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);


        $pagination = $this->paginator->paginate(
            $subCategories,
            $request->query->getInt("page", 1),
            10
        );
        return $this->render('sub_category/index.html.twig', [
            'sub_categories' => $pagination,
            'searchForm' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_sub_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SubCategoryRepository $subCategoryRepository): Response
    {
        $subCategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategoryRepository->save($subCategory, true);

            return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_category/new.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sub_category_show', methods: ['GET'])]
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('sub_category/show.html.twig', [
            'sub_category' => $subCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sub_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubCategory $subCategory, SubCategoryRepository $subCategoryRepository): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategoryRepository->save($subCategory, true);

            return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_category/edit.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sub_category_delete', methods: ['POST'])]
    public function delete(Request $request, SubCategory $subCategory, SubCategoryRepository $subCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $subCategory->getId(), $request->request->get('_token'))) {
            $subCategoryRepository->remove($subCategory, true);
        }

        return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
