<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['data'];
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true, 
            ])
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('pseudo')
            ->add('adress')
            ->add('zipcode')
            ->add('city')
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
            ]);
            if ($user && $user->getId()) {
                $builder->add('new_password', PasswordType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'New Password (leave blank if not changing)',
                ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
