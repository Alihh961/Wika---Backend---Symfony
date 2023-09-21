<?php

namespace App\Service;

use App\Entity\Audio;
use App\Entity\Image;
use App\Entity\Video;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class CreateMediaService
{


    public function __construct(
        private ParameterBagInterface $parameterBag,
        private SluggerInterface      $slugger
    )
    {
    }

    public function createMediaFromUploadFile(UploadedFile $uploadedFile, string $description , string $name): Video|Image|Audio
    {

        $uploadDirectory = $this->parameterBag->get('upload_file');
        $size = $uploadedFile->getSize(); // in bytes , divid by 10^6 to have the size in megabytes
        $mimeType = $uploadedFile->getMimeType(); // mimeType contains ext of file and its type(image , video , audio ,...)
        $fileType = explode("/", $mimeType)["0"];
        $ext = explode("/", $mimeType)["1"];


        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFileName);
        $newFileName = $safeFileName . "-" . uniqid() . "." . $ext;

        $uploadedFile->move(
            $uploadDirectory,
            $newFileName
        );



            $mediaEntity = new Image();

          $mediaEntity->setFormat($ext);
        $mediaEntity->setUrl($newFileName);
        $mediaEntity->setDescription($description);
        $mediaEntity->setSize($size);
        $mediaEntity->setName($name);


        return $mediaEntity;
    }
}