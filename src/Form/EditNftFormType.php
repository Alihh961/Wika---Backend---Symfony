<?php

namespace App\Form;

use App\Entity\Nft;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditNftFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', NumberType::class, [
                "label"=>"Nft Price",
                "required"=>true,
                "data"=>$options['price'],
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a price."
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                "label"=>"Image Description",
                "data"=>$options["description"],
                "constraints"=> [
                    new NotBlank([
                        "message"=>"Enter a description."
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "description"=>"" ,
            "price"=> null
        ]);
    }
}
