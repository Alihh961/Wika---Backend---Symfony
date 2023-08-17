<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Nft;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "constraints" => [
                    new NotBlank([
                        "message" => "Enter a name."

                    ])
                ]
            ])
            ->add('nfts', EntityType::class, [
                "class" => Nft::class,
                "choice_label" => "image",
                "multiple" => true,

            ])
            ->add('category', EntityType::class, [
                "class" => Category::class,
                "choice_label" => "name",
                "multiple" => false,
                "constraints" => [
                    new NotBlank([
                        "message" => "Select a category."

                    ])
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class,
        ]);
    }
}
