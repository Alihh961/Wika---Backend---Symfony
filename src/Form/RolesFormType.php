<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RolesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $currentRole = $options["currentRole"];

        $builder
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Admin" => "ROLE_ADMIN",
                    "Super Admin" => "ROLE_SUPER_ADMIN",
                    "User" => "ROLE_USER"
                ],
                "multiple" => true,
                "expanded" => true,
                "data" => [$currentRole],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            "currentRole" => []
        ]);
    }
}
