<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RoomRepository $ro )
    {

        $rooms = $ro->findAll();

        $random = array_rand($rooms, 2);



        return $this->render('home/index.html.twig', [
            'rooms1' => $rooms[$random[0]],
            'rooms2' => $rooms[$random[1]]
        ]);
    }
}
