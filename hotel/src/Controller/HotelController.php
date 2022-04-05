<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function hotel(RoomRepository $ro)
    {

        $rooms = $ro->findAll();

        return $this->render('hotel/index.html.twig', [
            'rooms' => $rooms
        ]);
    }
}
