<?php

namespace App\Form;

use App\Entity\Audio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a name."
                    ])
                ]
            ])
            ->add('description', TextareaType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a description."
                    ])
                ]
            ])
            ->add('url' , TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"File path error."
                    ])
                ]
            ])
            ->add('size',NumberType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Size error."
                    ])
                ]
            ])
            ->add('format', TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Format error."
                    ])
                ]
            ])
            ->add('duration', NumberType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Duration error."
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audio::class,
        ]);
    }
}
