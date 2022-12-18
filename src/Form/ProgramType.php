<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control my-2',
                        'placeholder' => 'Tapez le titre ici...',
                    ],
                    'help' => 'Ex : Le bureau des légendes, Le jeu de la dame, ...',
                    'help_attr' => [
                        'class' => 'text-secondary fw-light ',
                    ],
                ]
            )
            ->add('synopsis', TextareaType::class, [
                'label' => 'Synopsis',
                'required' => true,
                'attr' => [
                    'class' => ' form-control my-2',
                    'placeholder' => 'Tapez le synopsis ici...',
                ],
                'help' => 'Ex : Au sein de la DGSE, un département appelé le Bureau des légendes ...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ])
            ->add('posterFile', VichFileType::class, [
                'label' => 'Poster du programme',
                'attr' => [
                    'class' => ' form-control my-2',
                    'placeholder' => 'Chargez le poster ici...',
                ],
                'required' => false,
                'allow_delete' => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
                'help' => 'Chargez un poster inférieure à 1Mo et type jpeg, png, webp',
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
            ->add('actors', EntityType::class, [
                'class' => Actor::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'form-select my-2 '],
                'help' => 'Déroulez le menu et sélectionnez les acteurs jouant dans le programme ...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
                'by_reference' => false,
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
