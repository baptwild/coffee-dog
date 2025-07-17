<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Dog;
use App\Entity\Rate;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $is_admin = $options['is_admin'] ?? false;

        if ($is_admin) {
            $builder
                ->add('status', ChoiceType::class, [
                    'choices' => [
                        'En attente' => Booking::STATUS_EN_ATTENTE,
                        'Confirmé' => Booking::STATUS_CONFIRME,
                        'Annulé' => Booking::STATUS_ANNULE,
                    ],
                ])
                ->add('isActive', CheckboxType::class, [
                    'label' => 'Réservation active',
                    'required' => false,
                ]);
        }

        $builder
            ->add('dog', EntityType::class, [
                'class' => Dog::class,
                'choice_label' => 'name',
                'label' => 'Pour quel chien ?',
            ])

            ->add('effectiveDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de réservation :',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ])
            ->add('arrivalDatetime', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure d\'arrivée :',
                'hours' => range(8, 13),
                'minutes' => [0, 30],
            ])
            ->add('departureDatetime', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure de départ :',
                'hours' => range(11, 18),
                'minutes' => [0, 30],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'is_admin' => false,
        ]);
    }
}
