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
                    return new JsonResponse("File size can't exceeds 5MB" , 413);
                }
            }


            $email = $request->request->get("email");
            $subject = $request->request->get("subject");
            $senderName = $request->request->get("senderName");
            $message = $request->request->get("message");

            //check that all fields were filled except Image
            if($email && $subject && $senderName && $message){
                $info = [

                    "email" => $email,
                    "subject" => $subject,
                    "senderName" => $senderName,
                    "message" => $message

                ];

                $contactEntity = $this->uploadContactImageService->uploadFile($uploadedFile, $info);

                $this->entityManager->persist($contactEntity);
                $this->entityManager->flush();

                return new JsonResponse("Message received with success" , 202);
            }else{
                return new JsonResponse("All fields are required" , 400);

            }



        }
        catch (\Exception $e){
            return new JsonResponse($e , 406  );
        }

    }


}