<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RolesFormType;
use App\Form\SearchFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/super-admin/user')]
class UserController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator
    )
    {
    }

    #[Route('/', name: 'app_user_index', methods: ['GET' , 'POST'])]
    public function index(UserRepository $userRepository , Request $request): Response
    {
        $allUsers = $userRepository->findAll();


        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $searchValue = $form->get("searchValue")->getData();
            $searchBy = $form->get("searchBy")->getData();
            if(!empty($searchValue)){
                $allUsers = $userRepository->getQbAll( $searchValue,$searchBy);

            }

        }
        $pagination = $this->paginator->paginate(
            $allUsers,
            $request->query->getInt("page",1),
            10
        );
        return $this->render('user/index.html.twig', [
            'users' => $pagination,
            'searchForm'=>$form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($form->get("plainPassword")->getData());
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            "registrationForm" => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user , JWTTokenManagerInterface $JWTTokenManager): Response
    {
        $token = $JWTTokenManager->create($user);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            "token"=>$token,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'userForm' => $form,
        ]);
    }

    #[Route('/{id}/edit/roles', name: 'app_user_edit_roles', methods: ['GET', 'POST'])]
    public function editRoles(Request $request, User $user, UserRepository $userRepository): Response
    {
        $currentRoles = $user->getRoles();

        $form = $this->createForm(RolesFormType::class,null,  [
                'currentRole' => $currentRoles[0]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newRoles = $form->get("roles")->getData();

            $user->setRoles([$newRoles]);
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_edit', ["id"=>$user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/roles_edit.html.twig', [
            "form" => $form,
            "user" => $user
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
