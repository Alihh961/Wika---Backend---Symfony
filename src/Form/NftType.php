<?php

namespace App\Form;

use App\Entity\Nft;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                "mapped"=>false,
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a Nft name."
                    ])
                ]
            ])
//            ->add('users' , EntityType::class , [
//                "class" => User::class,
//                "choice_label"=>function ($user){
//
//
//                    return $user->getFirstName() . " " . $user->getLastName();
//                },
//
//                'multiple' => true,
//                'expanded' => true,
//                "required"=> false ,
//
//            ])
            ->add('SubCategory' , EntityType::class , [
                "class"=>SubCategory::class ,
                "multiple"=>true,
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Choose at least one category."
                    ])
                ]
            ] )
            ->add("file",FileType::class , [
                "mapped"=>false,
                "constraints"=> [
                    new NotBlank([
                        "message"=>"No Uploaded Image."
                    ])
                ]
            ])
            ->add("price" , NumberType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a price."
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                'mapped' => false,
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a description."
                    ])
                ]
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
