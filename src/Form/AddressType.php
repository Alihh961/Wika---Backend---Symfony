<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('municipality', TextType::class)
            ->add('department', TextType::class)
            ->add('region', TextType::class)
            ->add('path', TextType::class)
            ->add('buildingNumber', TextType::class)
            ->add('postCode', TextType::class, [
                "label_attr" => [
                    "class" => "special-label"
                ],
                "constraints" => [
                    new Regex(["pattern" => "/^[0-9]{5}$/",
                        "message" => "Post Code: Maximum 5 Numbers (no letters).",])

                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
