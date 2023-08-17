<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('municipality', TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a Municipality name."
                    ])
                ]
            ])
            ->add('department', TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a Department name."
                    ])
                ]
            ])
            ->add('region', TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a Region name."
                    ])
                ]
            ])
            ->add('path', TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a Path."
                    ])
                ]
            ])
            ->add('buildingNumber', TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a Building number."
                    ])
                ]
            ])
            ->add('postCode', TextType::class, [
                "label_attr" => [
                    "class" => "special-label"
                ],
                "constraints" => [
                    new Regex(["pattern" => "/^[0-9]{5}$/",
                        "message" => "Post Code: Maximum 5 Numbers (no letters).",]),

                        new NotBlank([
                            "message"=>"Enter a Postcode."
                        ])


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
