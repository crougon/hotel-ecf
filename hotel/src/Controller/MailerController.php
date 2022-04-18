<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {   
        $emailForm = $this->createFormBuilder()
            ->add('user', TextType::class, [
            'label' => 'Email',
            'attr' => ['placeholder' => 'Email']
        ])  
            ->add('message', TextareaType::class, [
                'attr' => array('rows' => '5')
            ])
            ->add('send', SubmitType::class, [
                'label' => 'envoyer',
                'attr' => [
                    'class' => 'btn btn-primary  float-left'
                ]
            ])

            ->getForm();

            $emailForm->handleRequest($request);

            if ($emailForm->isSubmitted()){

                $input = $emailForm->getData();
                $from = ($input['user']);
                $text = ($input['message']);

            

        
        $email = (new TemplatedEmail())

            ->from($from) //
            ->to('hotel@hotel.wip')
            ->subject('Réservation ')
            

            ->htmlTemplate('mailer/mail.html.twig')

            ->context([ 
                'text' => $text,
                'from' => $from
             ]);
        ;
        $mailer->send($email);
        $this->addFlash('message', 'Votre message a été transmis');
        return $this->redirect($this->generateUrl('mail'));
    }
        
        return $this->render('mailer/index.html.twig', [
        'emailForm' => $emailForm->createView()
    ]);
    }

}
