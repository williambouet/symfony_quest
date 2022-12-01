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
                'attr' => ['class' => 'tinymce form-control my-2',],
                ])
            ->add('year', NumberType::class, [
                'label' => 'Année',
                'required' => true,
                'attr' => ['class' => 'tinymce form-control my-2',],
                ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['class' => 'tinymce form-control my-2', "rows" => "3"]
                ])
            ->add('program', null, [
                'choice_label' => 'title',
                'attr' => ['class' => 'tinymce form-control my-2',],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
