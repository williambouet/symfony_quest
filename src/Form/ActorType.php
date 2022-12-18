<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ActorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control my-2',
                    'placeholder' => 'Tapez le nom ici...',
                ],
                'help' => 'Ex : Sylvain Téhin, Cécile Encieux ...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ])
            ->add('actorFile', VichFileType::class, [
                'label' => 'Image de l\'acteur',
                'attr' => [
                    'class' => ' form-control my-2',
                    'placeholder' => 'Chargez la photo ici...',
                ],
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'help' => 'Chargez une image inférieure à 1Mo et type jpeg, png, webp',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
            ])
            ->add('programs', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'form-select  my-2'],
                'help' => 'Déroulez le menu et sélectionnez les programmes où l\'acteur est présent...',
                'help_attr' => [
                    'class' => 'text-secondary fw-light ',
                ],
                'by_reference' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actor::class,
        ]);
    }
}
