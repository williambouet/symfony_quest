<?php

namespace App\Form;

use App\Entity\Episode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'attr' => ['class' => 'tinymce form-control my-2',],
            ])
            ->add('number', NumberType::class, [
                'label' => 'Numéro',
                'required' => true,
                'attr' => ['class' => 'form-control my-2'],
            ])
            ->add('synopsis', TextareaType::class, [
                'label' => 'Synopsis',
                'required' => true,
                'attr' => ['class' => 'tinymce form-control my-2', "rows" => "3"]
            ])
            ->add('season', null, [
                'choice_label' => 'number',
                'attr' => ['class' => 'form-select  my-2'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
