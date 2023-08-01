<?php

namespace App\Service;

use App\Entity\Audio;
use App\Entity\Image;
use App\Entity\Video;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

    public function createMediaFromUploadFile(UploadedFile $uploadedFile, string $description): Video|Image|Audio
    {

        $uploadDirectory = $this->parameterBag->get('upload_file');

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


        if ($fileType == "image") {
            $mediaEntity = new Image();
        } else if ($fileType == "video") {
            $mediaEntity = new Video();
            $mediaEntity->setDuration(50);
        } else if ($fileType == "audio") {
            $mediaEntity = new Audio();
            $mediaEntity->setDuration(50);
        }


        $mediaEntity->setFormat($ext);
        $mediaEntity->setUrl($newFileName);
        $mediaEntity->setDescription($description);
        $mediaEntity->setSize(1);
        $mediaEntity->setName('toto');


        return $mediaEntity;
    }
}