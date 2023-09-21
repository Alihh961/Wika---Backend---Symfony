<?php

namespace App\Controller\Api;


use App\Controller\Api\services\UploadContactImageService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route("api/contact")]
class ApiContactController extends AbstractController
{

    public function __construct(
        private UploadContactImageService $uploadContactImageService,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route("", methods: ["POST"])]
    public function upload(Request $request)
    {
        try{
            if($uploadedFile = $request->files->get("image")) {

                $size = $uploadedFile->getSize(); // in bytes , divid by 10^6 to have the size in megabytes

                if ($size > 5242880) {
                    return new JsonResponse(["Error" => "File size can't exceeds 5MB"]);
                }
            }


            $email = $request->request->get("email");
            $subject = $request->request->get("subject");
            $senderName = $request->request->get("senderName");
            $message = $request->request->get("message");

            $info = [

                "email" => $email,
                "subject" => $subject,
                "senderName" => $senderName,
                "message" => $message

            ];

            $contactEntity = $this->uploadContactImageService->uploadFile($uploadedFile, $info);

            $this->entityManager->persist($contactEntity);
            $this->entityManager->flush();

            return new JsonResponse(["message" => "Message received with success"] , Response::HTTP_ACCEPTED);


        }
        catch (\Exception $e){
            return new JsonResponse(["Error" => $e] , Response::HTTP_NOT_ACCEPTABLE  );
        }

    }


}