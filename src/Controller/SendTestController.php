<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class SendTestController extends AbstractController{

    #[Route("send")]
    public function index(MailerInterface $mailer){

        $email = new Email();
        $email->from("me@you.com")
            ->to("hajhassan.ali92@gmail.com")
            ->subject("Hello")
            ->text("Hahaha");

        try{
            $mailer->send($email);
            return $this->json("Sent with success");

        }

        catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
