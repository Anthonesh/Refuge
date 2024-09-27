<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\ReservationForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phoneNumber')
            ->add('streetNumber')
            ->add('streetName')
            ->add('postalCode')
            ->add('city')
            ->add('country')
            ->add('reservation')
            ->add('calendar', HiddenType::class, [
                'mapped' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationForm::class,
        ]);
    }
}
