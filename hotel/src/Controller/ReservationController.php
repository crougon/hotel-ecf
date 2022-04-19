<?php

namespace App\Controller;


use App\Entity\Reservation;
use App\Entity\Room;
use App\Repository\ReservationRepository;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/room", name="reservations")
 */
class ReservationController extends AbstractController
{
    public function index()
    {
        
    }


    /**
     * @Route("/res/{id}", name="res")
     */

    public function reserve(Request $request, Room $room ){
        $reserv = new Reservation();
        
        $resform = $this->createFormBuilder()
            ->add('datein', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date d\'entrée'
            ])
            ->add('dateout', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date d\'sortie',
                'attr' => ['placeholder' => 'Nom Prénom']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Email']
            ])
            //-----------
            ->add('status', TextType::class, [
                'label' => ' Nom',
                'attr' => ['placeholder' => 'Nom Prénom']
            ] )
            //-----------
            ->add('Enregistrer', SubmitType::class)
            ->getForm()
        ;

        $resform->handleRequest($request);

        if($resform->isSubmitted()){
            $input = $resform->getData();

            $res = new Reservation();
            $res->setDatein($input['datein']);

            $res->setDateout($input['dateout']);

            $res->setStatus($input['status']);

            $res->setEmail($input['email']);

            $res->setName($room->getName());

            $res->setCategory($room->getCategory());

            $res->setPrice($room->getPrice());

            

            $em = $this->getDoctrine()->getManager();
            $em->persist($res);
            $em->flush();

            

            $this->addFlash('res', 'Votre réservation a été prise en compte, merci de régler sur place' );


            //return $this->redirect($this->generateUrl('home'));
        }

        
    

        return $this->render('reservation/index.html.twig', [
            'resform' => $resform->createView()
        ]);

    }


    /**
     * @Route("/reservations", name="reserved")
     */


    
    public function show(ReservationRepository $resrep)
    {
        
        $res = $resrep->findAll();


        return $this->render('reservation/res.html.twig', [
            'res' => $res
        ]);

    }

    //-----------------------------------------

    






    //-----------------------------------------


    






    //-----------------------------------------








    /**
     * @Route("/reservations/delete/{id}", name="reservedDelete")
     */


     public function delete($id, ReservationRepository $resdel){
        $em = $this->getDoctrine()->getManager();
        $res = $resdel->find($id);
        $em->remove($res);
        $em->flush();

        //messagge
        $this->addFlash('success', 'La réservation a été supprimé avec succès' );
        return $this->redirect($this->generateUrl('reservationsreserved'));

     }



    

    

    
    
    
}

