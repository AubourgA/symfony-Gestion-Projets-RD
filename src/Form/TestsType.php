<?php

namespace App\Form;

use App\Entity\Tests;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('critere', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'ex: Essai Mecanique-rc7',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('pres', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=> 'ex: compression'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false,
            ])
            ->add('duedate',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'ex: 7j'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false,
            ])
            ->add('unit', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'ex: MPa',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false,
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
            'data_class' => Tests::class,
        ]);
    }
}
