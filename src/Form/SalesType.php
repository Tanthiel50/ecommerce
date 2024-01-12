<?php

namespace App\Form;

use App\Entity\Sales;
use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class SalesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message')
            ->add('discount')
            ->add('date_begin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('date_end', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('id_product', EntityType::class, [
                'class' => Products::class,
                'choice_label' => 'name', 
                'multiple' => true,
                'expanded' => true, 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sales::class,
            'constraints' => [
                new Callback([$this, 'validateDates']),
            ],
        ]);
    }

    public function validateDates(Sales $sales, ExecutionContextInterface $context)
    {
        if ($sales->getDateEnd() && $sales->getDateBegin() > $sales->getDateEnd()) {
            $context->buildViolation('La date de fin ne peut pas être antérieure à la date de début.')
                ->atPath('date_end')
                ->addViolation();
        }
    }
}