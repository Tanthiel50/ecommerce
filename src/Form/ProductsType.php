<?php

namespace App\Form;

use App\Entity\Sales;
use App\Entity\Products;
use App\Form\ImagesType; 
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('stock')
            ->add('color')
            ->add('size')
            ->add('sales', EntityType::class, [
                'class' => Sales::class,
                'choice_label' => 'message',
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'title', 
            ])
            ->add('image', FileType::class, [
                'label' => 'Image produit',
                'multiple' => true,
                'mapped' => false, 
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
