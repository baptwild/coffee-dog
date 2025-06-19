<?php

namespace App\Form;

use App\Entity\Dog;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du chien',
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Âge du chien',
                'required' => false,
            ])
            ->add('breed', TextType::class, [
                'label' => 'Race du chien',
            ])
            ->add('size', ChoiceType::class, [
                'label' => 'Taille du chien',
                'choices' => [
                    'Petit' => Dog::SIZE_PETIT,
                    'Moyen' => Dog::SIZE_MOYEN,
                    'Grand' => Dog::SIZE_GRAND,
                ],
                'placeholder' => 'Sélectionnez une taille',
                'required' => false,
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Informations supplémentaires (facultatif)',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dog::class,
        ]);
    }
}
