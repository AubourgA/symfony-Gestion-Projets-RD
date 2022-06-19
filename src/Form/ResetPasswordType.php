<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Entrez votre nouveau mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
                ])
            ->add('Submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Reinitialiser'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
