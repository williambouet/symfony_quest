<?php

namespace App\Form;

use DateTime;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => true,
                'attr' => [
                    'class' => 'form-control my-2',
                    "rows" => "3",
                    'placeholder' => 'Tapez votre commentaire ici...',
                ],
                'help' => 'Ex : Le jeu du principal acteur est très efficace,...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ])
            ->add('rate', RangeType::class, [
                'label' => 'Note',
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'class' => 'w-100 my-2',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
