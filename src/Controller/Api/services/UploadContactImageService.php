<?php


namespace App\Controller\Api\services;


use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadContactImageService
{

    public function __construct(
        private ParameterBagInterface $parameterBag,
        private SluggerInterface      $slugger
    )
    {
    }

    public function uploadFile(UploadedFile|null $uploadedFile, array $info)
    {

        $fileName = "";
        if ($uploadedFile) {
            $uploadDirectory = $this->parameterBag->get("upload_file_contact");
            $mimeType = $uploadedFile->getMimeType();
            $ext = explode("/", $mimeType)["1"];


            $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName = $this->slugger->slug($originalFileName);
            $newFileName = $safeFileName . "-" . uniqid() . "." . $ext;
            $fileName = $newFileName;

            $uploadedFile->move(
                $uploadDirectory,
                $newFileName
            );
        }


        $contactEntity = new Contact();
        $contactEntity->setDate(new \DateTime());
        $contactEntity->setEmail($info["email"]);
        $contactEntity->setMessage($info["message"]);
        $contactEntity->setSenderName($info["senderName"]);
        $contactEntity->setSubject($info["subject"]);
        $contactEntity->setImageUrl($fileName);


        return $contactEntity;

    }
}