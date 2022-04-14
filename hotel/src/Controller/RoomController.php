<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;

    /**
     * @Route("/room", name="room.")
     */

class RoomController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(RoomRepository $ro): Response
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
            //galerie
            $galeries = $form->get('galeries')->getData();

            // loop galerie
            foreach($galeries as $galerie){
                $fichier = md5(uniqid()) . '.' . $galerie->guessExtension();

                $galerie->move(
                    $this->getParameter('galerie_folder'),
                    $fichier
                );
            //     stock galerie in DB

                $gal = new Galerie();
                $gal->setName($fichier);
                $room->addGalery($gal);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            //$em->flush();
            //return $this->redirect($this->generateUrl('room.edit'));
            // end galerie
            
            //Entity manager
            $em = $this->getDoctrine()->getManager();
            //$image = $request->files->get('room')['image'];
            $images = $form->get('image')->getData();
            
            foreach($images as $image){
                $filename = md5(uniqid()). '.'. $image->guessExtension();

                $image->move(
                    $this->getParameter('images_folder'),
                    $filename
                );

                
                $room->setImage($filename);
            }
            

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
        $this->addFlash('success', 'La chambre a été supprimé avec succès' );

        return $this->redirect($this->generateUrl('room.edit'));
    }


    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Room $room){
        
        return $this->render('room/show.html.twig', [
            'room' => $room
        ]);

    }  

    //-----------------------------------------

    /**
     * @Route("/res/{id}", name="res")
     */

    public function reserve(Request $request, Room $room){
        
        
        
    

        //return $this->render('reservation/index.html.twig', [
        //    'resform' => ->createView()
        //]);

    }

    //-------------------------------------------------------

    // edit

    /**
     * @Route("/modif/{id}", name="modif", methods={"GET", "POST"})
     */
    public function edit(Request $request, Room $room, RoomRepository $roomRep): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roomRep->add($room);

            //----------
            //galerie
            $galeries = $form->get('galeries')->getData();

            // loop galerie
            foreach($galeries as $galerie){
                $fichier = md5(uniqid()) . '.' . $galerie->guessExtension();

                $galerie->move(
                    $this->getParameter('galerie_folder'),
                    $fichier
                );
            //     stock galerie in DB

                $gal = new Galerie();
                $gal->setName($fichier);
                $room->addGalery($gal);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();

            //-----------

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/edit.html.twig', [
            'liste' => $room,
            'form' => $form,
        ]);
    }

 // ----------------------------------
 
 /**
  * @Route("/sup/image/{id}", name="sup_img", methods={"DELETE"})
  */
  
  public function deleteImage(Galerie $gal, Request $request){
      $data = json_decode($request->getContent(), true);
      
      // vérifier si le token est valide
      
      if($this->isCsrfTokenValid('delete'.$gal->getId(), $data['_token'])){
          // récupèrer nom de l'image
          $name = $gal->getName();
          // suprimer le fichier
          unlink($this->getParameter('galerie_folder').'/'.$name);
          // supprimer de la base
          $em = $this->getDoctrine()->getManager();
          $em->remove($gal);
          $em->flush();
          
          // réspond en json
          return new JsonResponse(['success ' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
    // ----------------------------------
}
