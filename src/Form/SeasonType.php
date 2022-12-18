<?php

namespace App\Form;

use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', NumberType::class, [
                'label' => 'Numéro',
                'required' => true,
                'attr' => [
                    'class' => 'form-control my-2',
                    'placeholder' => 'Indiquez le numéro de la saison',
                ],
                'help' => 'Ex : 10',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',

                ],
            ])
            ->add('year', NumberType::class, [
                'label' => 'Année',
                'required' => true,
                'attr' => [
                    'class' => 'form-control my-2',
                    'placeholder' => 'Indiquez l\'année de diffusion',
                ],
                'help' => 'Ex : 2010',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['class' => 'form-control my-2', "rows" => "3"]
            ])
            ->add('program', null, [
                'choice_label' => 'title',
                'attr' => [
                    'class' => 'form-control my-2',
                    "rows" => "3",
                    'placeholder' => 'Tapez la description ici...',
                ],
                'help' => 'Ex : Cette saison permet de faire la découverte de nouveaux personnages, dont un particulièrement...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
