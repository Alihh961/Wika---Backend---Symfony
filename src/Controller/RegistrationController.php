<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\VerifyEmail;
use App\Form\RegistrationFormType;
use App\Form\VerifyEmailFormType;
use App\Repository\UserRepository;
use App\Repository\VerifyEmailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/register')]
class RegistrationController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $httpClient
    )
    {
    }

    #[Route('/', name: 'app_register')]
    public function register(Request                  $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,
                             JWTTokenManagerInterface $JWTTokenManager): Response
    {

        //redirect to home page if the user is logged in
        if ($this->getUser()) {

            return $this->redirectToRoute("app_home");
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $jwt = $JWTTokenManager->create($user);;
            $requestedTime = new \DateTime("now", new \DateTimeZone("Europe/Paris"));
            $expiredTime = new \DateTime("+30 days" , new \DateTimeZone("Europe/Paris"));
            $formatedRequestedTime = $requestedTime->format("Y-m-d");

            // create a verify Email row to insert in database
            $verifyEmail = new VerifyEmail();
            $verifyEmail->setToken($jwt);
            $verifyEmail->setRequestedAt($requestedTime);
            $verifyEmail->setExpiresAt($expiredTime);
            $verifyEmail->setUser($user);


            $entityManager->persist($verifyEmail);
            $entityManager->persist($user);

            // do anything else you need here, like send an email

            $verifyLink = 'https://127.0.0.1:8000/register/verify/' . $verifyEmail->getToken();

            $this->httpClient->request('POST', "https://api.brevo.com/v3/smtp/email", [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => "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",
                    'content-type' => 'application/json'
                ],
                'json' => [
                    "sender" => [
                        'name' => "Wika-WOO",
                        'email' => "no-reply-verifyEmail@wika.com"
                    ],
                    "to" => [
                        [
                            'email' => $user->getEmail(),
                            'name' => $user->getEmail()
                        ],

                    ],
                    "subject" => "Reset Your Password!",
                    "htmlContent" => "<a href='{$verifyLink}'>Click here to verify your account, you have 30 days starting from $formatedRequestedTime</a>"
                ]
            ]);
            // we update the database at the end to be sure that the whole process is done
            $entityManager->flush();


            return $this->redirectToRoute('app_register_check');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route("/check", name: "app_register_check")]
    public function verifyEmail()
    {

        $text = "Please check your email inbox to validate your account , the link is valid for 30 days";
        return $this->render("registration/check_email.html.twig", [
            "text" => $text
        ]);
    }

    #[Route("/verify/{token}", name: "app_register_verify_token")]
    public function verifyToken(string $token, EntityManagerInterface $entityManager , Request $request, VerifyEmailRepository $verifyEmailRepository, UserRepository $userRepository)
    {

        // select the VerifyEmail Entity if the token existed in the database
        $receivedVerifyEmailEntity = $verifyEmailRepository->findBy(["token" => $token]);

//        dd($receivedVerifyEmailEntity);
        $form = $this->createForm(VerifyEmailFormType::class);
        $form->handleRequest($request);


        if ($receivedVerifyEmailEntity) { //if the token exists in the database

            $verifyEntity = $receivedVerifyEmailEntity[0]; // select the VerifyEmail Entity from the Array of Entities
            $ReceivedUserId = $verifyEntity->getUser()->getId();

            if ($form->isSubmitted() && $form->isValid()) {

                //select the user related to the entered email
                $enteredEmail = $form->get("email")->getData();
                $enteredEmailUser = ($userRepository->findBy(["email" => $enteredEmail]))[0];
                $enteredEmailUserId = $enteredEmailUser->getId();

                 // check if the token received related to the same user of that entered
                if ($verifyEntity->getToken() === $token && $enteredEmailUserId === $ReceivedUserId) {


                    $enteredEmailUser->setIsVerified(true);
                    $verifyEmailRepository->remove($verifyEntity);

                    $entityManager->persist($enteredEmailUser);
                    $entityManager->persist($verifyEntity);
                    $entityManager->flush();




                    return $this->redirectToRoute("app_home");

                } else {
                    $text = "Wrong Email!";

                    return $this->render("registration/check_email.html.twig", [
                        "text" => $text,
                        "form" => $form->createView(),
                        "displayForm" => true
                    ]);
                }


            }
            $text = "Please enter your email to verify!";
            return $this->render("registration/check_email.html.twig", [
                "text" => $text,
                "form" => $form->createView(),
                "displayForm" => true
            ]);
        }
        $text = "No token found , please click in the sent url in your email inbox.";

        return $this->render("registration/check_email.html.twig", [
            "text" => $text,
            "form" => $form->createView(),
            "displayForm" => false
        ]);

    }


}
