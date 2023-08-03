<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Nft;
use App\Entity\SubCategory;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NftType extends AbstractType
{

    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' , TextType::class , [
                "required"=>true ,
                "mapped"=>false
            ])
            ->add('users' , EntityType::class , [
                "class" => User::class,
                "choice_label"=>function ($user){


                    return $user->getFirstName() . " " . $user->getLastName();
                },

                'multiple' => true,
                'expanded' => true,
                "required"=> false ,

            ])
            ->add('SubCategory' , EntityType::class , [
                "class"=>SubCategory::class ,
                "multiple"=>true
            ] )
            ->add("file",FileType::class , [
                "mapped"=>false
            ])
            ->add("price" , NumberType::class , [])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                'mapped' => false
            ])

//            ->add("image" , ImageType::class , [
//
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nft::class,
        ]);
    }
}
