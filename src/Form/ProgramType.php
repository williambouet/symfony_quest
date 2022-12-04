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
                    'attr' => [
                        'class' => 'tinymce form-control my-2',
                        'placeholder' => 'Tapez le titre ici...',
                    ],
                    'help' => 'Ex : Le bureau des légendes, Le jeu de la dame, ...',
                    'help_attr' => [
                        'class' => 'text-secondary fw-light ',
                    ],
                ])
            ->add('synopsis', TextareaType::class, [
                'label' => 'Synopsis',
                'required' => true,
                'attr' => [
                    'class' => 'tinymce  form-control my-2',
                    'placeholder' => 'Tapez le synopsis ici...',
                ],
                'help' => 'Ex : Au sein de la DGSE, un département appelé le Bureau des légendes ...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ])
            ->add('poster', TextType::class, [
                'label' => 'Poster',
                'required' => true,
                'attr' => [
                    'class' => 'tinymce  form-control my-2',
                    'placeholder' => 'Tapez le nom du poster ici...',
                ],
                'help' => 'Nom identique à la catégorie. Ex : Pour la catégorie Action -> Poster = Action.jpg ...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
                ])
            ->add('category', null, [
                'choice_label' => 'name',
                'attr' => ['class' => 'form-select  my-2'],
                'help' => 'Déroulez le menu et sélectionnez la catégorie ...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
