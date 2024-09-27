<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Volunteer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolunteerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('endTime', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('places',IntegerType::class, [
                'required' => false,
            ])
            ->add('numberOfVolunteers', IntegerType::class, [
                'label' => 'Nombre de réservations',
                'required' => false,
            ])
            ->add('calendar', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('user', HiddenType::class, [
                'mapped' => false,
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Volunteer::class,
        ]);
    }
}
