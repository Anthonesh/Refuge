<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\ReservationForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('calendar', EntityType::class, [
                'class' => Calendar::class,
                'choice_label' => 'title', // or any property of Calendar entity that you want to display
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
