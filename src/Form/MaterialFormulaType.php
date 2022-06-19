<?php

namespace App\Form;

use App\Entity\MaterialFormula;
use App\Entity\Materials;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MaterialFormulaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('idMaterial', EntityType::class, [
            'class' => Materials::class,
            'choice_label' => 'getName',
            'placeholder' => 'Selectionner MP',
            'attr' => [
                'class' => 'form-control',
            ],
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.name', 'ASC');
            },
            'label' => false,
            'by_reference' => false,
            ])
            ->add('quantity',  TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Quantity'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'label' => false
            ])
            ->add('unit', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'unit',
                    'value'=> 'g'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'label'=>false
            ])   
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaterialFormula::class,
        ]);
    }
}
