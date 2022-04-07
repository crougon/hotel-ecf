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

/**
 * @Route("/room", name="app_reservation")
 */
class ReservationController extends AbstractController
{
    public function index()
    {
        //return $this->render('reservation/index.html.twig', [
        //    'controller_name' => 'ReservationController',
        //]);
    }

    /**
     * @Route("/rest/", name="rest")
     */

    /**
     * @Route("/res/", name="res")
     *///public function reserve(Room $rooms){
//
       // return $this->render('reservation/index.html.twig', [
       //     'rooms' => $rooms
       // ]);
//
   // }

    

    
    
    
}

//--------------------------

//$reservation = new Reservation();
//$reservation->setDatein($res->getDatein());
//$reservation->setDateout($res->getDateOut());
//$reservation->setPrice($room->getPrice());
//$reservation->setStatus("Réservé");