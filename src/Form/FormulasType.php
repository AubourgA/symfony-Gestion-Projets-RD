<?php

namespace App\Form;

use App\Entity\Formulas;
use App\Entity\MaterialFormula;
use App\Entity\Materials;
use App\Form\ProjectsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Protocole',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])    
           ->add('materialFormulas', CollectionType::class, [
            'entry_type' => MaterialFormulaType::class,
            'entry_options' => ['label'=> false],
            'allow_add' => true,
            'prototype' => true,
            'by_reference' => false //permet d'aller chercher un add et non un set
                       ])
                       
          ->add('submit', SubmitType::class, [
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
            'data_class' => Formulas::class,
        ]);
    }
}
