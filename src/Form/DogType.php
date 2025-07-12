<?php

namespace App\Form;

use App\Entity\Dog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class DogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du chien',
            ])

            ->add('photo', FileType::class, [
                'label' => 'Photo du chien (JPG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez uploader une image JPG ou PNG valide.',
                    ]),
                ],
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
