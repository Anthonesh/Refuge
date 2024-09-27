<?php

namespace App\Form;

use App\Entity\Donations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class DonationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastName', TextType::class, [
            'label' => 'Nom', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Nom','class' => 'js-nom-don']
        ])
        ->add('firstName', TextType::class, [
            'label' => 'Prénom', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le prénom est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Prénom','class' => 'js-prenom-don']
        ])
        ->add('streetNumber', TextType::class, [
            'label' => 'Numéro de rue', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le numéro de rue est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Numéro de rue','class' => 'js-numeroRue-don']
        ])
        ->add('streetName', TextType::class, [
            'label' => 'Libellé de la rue', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le libellé de la rue est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Libellé de la rue','class' => 'js-libelleRue-don']
        ])
        ->add('postalCode', TextType::class, [
            'label' => 'Code Postal', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le code postal est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Code Postal','class' => 'js-codePostal-don']
        ])
        ->add('city', TextType::class, [
            'label' => 'Ville', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'La ville est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Ville','class' => 'js-ville-don']
        ])
        ->add('country', TextType::class, [
            'label' => 'Pays', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le pays est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Pays','class' => 'js-pays-don']
        ])
        ->add('phone', TextType::class, [
            'label' => 'Téléphone', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le numéro de téléphone est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Téléphone','class' => 'js-telephone-don']
        ])
        ->add('mail', EmailType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer un email',
                ]),
                new Email([
                    'message' => 'L\'email {{ value }} n\'est pas un email valide.',
                ]),
            ],
            'label' => 'Email', 
            'required' => true,
            'attr' => ['placeholder' => 'Email','class' => 'js-email-don']
        ])
        ->add('amount', IntegerType::class, [
            'label' => 'Montant du don', 
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le montant du don est obligatoire.',
                ]),
            ],
            'attr' => ['placeholder' => 'Montant du don','class' => 'js-montant-don']
        ])
        ->add('currency', ChoiceType::class, [
            'label' => 'Monnaie',
            'required' => true, 
            'constraints' => [
                new NotBlank([
                    'message' => 'La monnaie est obligatoire.',
                ]),
            ],
            'attr'=>['class' => 'js-monnaie-don'],
            'choices' => [
                'EUR' => 'EUR',
                'USD' => 'USD',
                'GBP' => 'GBP',
            ],
            'placeholder' => 'Choisissez une monnaie',
        ])
            // ->add('stripe_transaction_id_don')
            // ->add('paiement_statut_don')
;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donations::class,
        ]);
    }
}
