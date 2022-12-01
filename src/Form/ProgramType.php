<?php

namespace App\Form;

use App\Entity\Program;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        
        $builder
            ->add(
                'title', TextType::class, [
                    'label' => 'Titre',
                    'required' => true,
                ])
            ->add('synopsis', TextareaType::class, [
                'label' => 'Synopsis',
                'required' => true,
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('poster', TextType::class, [
                'label' => 'Synopsis',
                'required' => true,])
            ->add('category', null, ['choice_label' => 'name']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
