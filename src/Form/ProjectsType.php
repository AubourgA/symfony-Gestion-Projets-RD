<?php

namespace App\Form;

use App\Entity\Projects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
class ProjectsType extends AbstractType
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
            ->add('goals', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('TimeForcast', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
       
            ->add('status', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choices' => [
                    'En Cours' => 'en cours',
                    'A Venir' => 'a venir',
                    'Suspendu' => 'suspendu',
                    'Arrete' => 'arrete',
                    'Terminé' => 'termine',
                ],
            ])
            ->add('isVisible', CheckboxType::class, [
                'attr' => [
                    'class' => "form-group apple-switch"
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4 '
                ],
                'label' => 'Public ? ',
               'required' => false,
            ])
            
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Enregistrer'
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
