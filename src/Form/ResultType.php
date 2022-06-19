<?php

namespace App\Form;

use App\Entity\Results;
use App\Entity\Tests;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('tests', EntityType::class, [
            'class' => Tests::class,
            'choice_label' => 'getCritere',
            'placeholder' => 'Selectionner un critere',
            'attr' => [
                'class' => 'form-control',
            ],
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
           
            'label' => false,
            // 'by_reference' => false,
            ])
            ->add('value', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Resultat',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
         
          ->add('submit',  SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4'
            ],
            'label' => 'Enregistrer'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Results::class,
        ]);
    }
}
