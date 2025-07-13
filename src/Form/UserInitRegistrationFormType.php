<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInitRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'attr' => [
                    'placeholder' => 'Votre prénom...'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Votre nom...'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email :',
                'attr' => [
                    'placeholder' => 'Votre email...'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe :',
                    'attr' => [
                        'placeholder' => 'Votre mot de passe...'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe :',
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe...'
                    ]
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'mapped' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
