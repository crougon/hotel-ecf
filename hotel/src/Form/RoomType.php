<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Images;
use App\Entity\Room;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [ 
                'label' => 'Titre'
            ])
            ->add('image', FileType::class, [
                //'class' => Images::class,
                'label' => 'Joindre des images',
                'multiple' => true,
                'mapped' => false,
                'required' => false

            ])
            
            //->add('image', EntityType::class, [
            //    'class' => Images::class,
            //    
            //    //'class' => FileType::class,
            //    'label' => 'Joindre des images',
            //    'multiple' => true,
            //    //
            //    //'mapped' => false,
            //    'data_class' => null,
            //    'empty_data' => ''
            //    //
            //])
            ->add('description', )
            ->add('category', EntityType::class, [
                'class' =>Category::class,
                'label' => 'Hotel'
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix'
            ])
            
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
