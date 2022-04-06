<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistryController extends AbstractController
{
    /**
     * @Route("/reg", name="reg")
     */
    public function reg(Request $request, UserPasswordHasherInterface  $passEncoder)
    {

        $regform = $this->createFormBuilder()
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'attr' => ['placeholder' => 'Nom']
        ]) 
        ->add('name', TextType::class, [
            'label' => 'Prénom',
            'attr' => ['placeholder' => 'Prénom']
        ])
        ->add('username', TextType::class,[
            'label' => 'Utilisateur',
            'attr' => ['placeholder' => 'Utilisateur']
            ])
        ->add('password', RepeatedType::class,[
            'type' => PasswordType::class,
            'required' => true,
            'first_options' => ['label' => 'Mot de passe', 
            'attr' => ['placeholder' => 'Mot de passe']],
            'second_options' => ['label' => 'Repeter Mot de passe',
            'attr' => ['placeholder' => 'Mot de passe']]
        ])
        ->add('Enregistrer', SubmitType::class)
        ->getForm()
        ;

        $regform->handleRequest($request);

        if ($regform->isSubmitted()){
            $input = $regform->getData();

            $user = new User();
            $user->setUsername($input['username']);

            $user->setPassword(
                $passEncoder->hashPassword($user, $input['password'])
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }




        return $this->render('registry/index.html.twig', [
            'regform' => $regform->createView()
        ]);
    }
}
