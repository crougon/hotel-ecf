<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
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
        // form
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted()){    
            //Entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();

            return $this->redirect($this->generateUrl('room.edit'));
        }
        

        //Response
        return $this->render('room/create.html.twig', [
            'createForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function delete($id, RoomRepository $rr ){
        $em = $this->getDoctrine()->getManager();
        $room = $rr->find($id);
        $em->remove($room);
        $em->flush();

        //messagge
        $this->addFlash('success', 'Room was remove successfully' );

        return $this->redirect($this->generateUrl('room.edit'));
    }

    
}
