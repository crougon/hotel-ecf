<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/room", name="room.")
     */

class RoomController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(RoomRepository $ro)
    {

        $rooms = $ro->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("/create", name="create")
     */


    public function create(Request $request){
        $room = new Room();
        $room->setName('Romance floor');
        $room->setDescription('Romance floor');
        
        //Entity manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($room);
        $em->flush();

        //Response
        return new Response("Room has been created");
    }

    
}
