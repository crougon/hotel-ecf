<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {

        $email = (new TemplatedEmail())
            ->from('hotel@hotel.wip')
            ->to('client@hotel.com') //
            ->subject('Réservation ')
            ->text('')

            ->htmlTemplate('mailer/mail.html.twig')
        ;
        $mailer->send($email);

        return new Response('Email envoyé');
    }
}
