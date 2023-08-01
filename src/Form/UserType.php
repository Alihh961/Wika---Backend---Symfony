<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("register", RegistrationFormType::class,
                [
                    "mapped" => false,
                    "label"=>" "
                ])
            ->add('roles', ChoiceType::class,
                [
                    "mapped" => false,
                    "label" => "Roles",

                    "choices" => [
                        "Admin" => "ADMIN_ROLE",
                        "User" => "USER_ROLE"
                    ]
                ]

            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
