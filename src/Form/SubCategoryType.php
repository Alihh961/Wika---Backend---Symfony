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

class SubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('nfts', EntityType::class , [
                "class"=>Nft::class ,
                "choice_label"=>"image",
                "multiple"=>true
            ])
            ->add('Category',EntityType::class , [
                "class"=>Category::class,
                "multiple"=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class,
        ]);
    }
}
