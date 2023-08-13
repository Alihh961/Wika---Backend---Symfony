<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                "autocomplete"=>false,
                "constraints" => new Regex([
                    "pattern" => "/^[a-zA-Z]{2,}$/",
                    "message" => "At least two letters, only letters are allowed"

                ])
            ])
            ->add('lastName' , TextType::class , [
                "constraints" => new Regex([
                    "pattern" =>  "/^[a-zA-Z]{2,}$/",
                    "message" => "At least two letters, only letters are allowed"
                ])
            ])
            ->add('dateOfBirth' ,DateType::class, [
                'label_attr'=> [
                    "class" => "position-label date-input",
                ]
                ,
                'widget' => 'single_text',
            ])
            ->add('email')
            ->add('gender', ChoiceType::class, [
                "choices" => [
                    "Male" => "male",
                    "Female" => "female"
                ],
                "label_attr" => [
                    "class" => "position-label"
                ]
                ,

                "expanded" => "true",
                'attr' => [
                    'class' => 'toto'
                ]
            ])
            ->add("address", AddressType::class)

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
