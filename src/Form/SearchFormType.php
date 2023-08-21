<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchValue' , TextType::class , [
                "required"=>false
            ])
            ->add("searchBy", ChoiceType::class , [
                "multiple"=>false,
                "choices"=>[
                    "First Name"=>"firstName",
                    "Last Name"=>"lastName",
                    "Email"=>"email",
                    "Gender"=>"gender",
                ],
            ])
//            ->add("role" , ChoiceType::class , [
//                "multiple"=>false,
//                "choices"=> [
//                        "All" => "",
//                        "ROLE_USER"=>"ROLE_USER", // label => value
//                        "ROLE_ADMIN"=>"ROLE_ADMIN" ,
//                        "ROLE_SUPER_ADMIN"=>"ROLE_SUPER_ADMIN"
//                ],
//                "data"=>"All",
//                "required"=>false
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
