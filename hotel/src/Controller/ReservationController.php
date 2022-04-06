<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="app_reservation")
     */
    public function index()
    {
        //return $this->render('reservation/index.html.twig', [
        //    'controller_name' => 'ReservationController',
        //]);
    }

    /**
     * @Route("/reserve/{id}", name="reserve")
     */

    public function reserve(Room $room, ReservationRepository $res, Request $request){

        $resform = $this->createFormBuilder()
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'attr' => ['placeholder' => 'email']
        ])
        ->add('datein', DateType::class, [
            'label' => 'Date d\'entrée',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'
            ]
        ])
        ->add('dateout', DateType::class, [
            'label' => 'Date de sortie',
            'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'
            ]
        ])
        ->add('Réserver', SubmitType::class)
        ->getForm();   

        $resform->handleRequest($request);

        if ($resform->isSubmitted()){
            $input = $resform->getData();

            $reservation = new Reservation();

            $reservation->setEmail($input['email']);

            $reservation->setDatein($input['datein']);

            $reservation->setDateout($input['dateout']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();



            $this->addFlash('reserver', 'La chambre a été réservé');
    
            return $this->redirect($this->generateUrl('home'));
        
        }

        return $this->render('room/show/{id}.html.twig', [
            'resform' => $resform->createView()
        ]);
        
        
        
        
    }
    
    
}

//--------------------------

//$reservation = new Reservation();
//$reservation->setDatein($res->getDatein());
//$reservation->setDateout($res->getDateOut());
//$reservation->setPrice($room->getPrice());
//$reservation->setStatus("Réservé");