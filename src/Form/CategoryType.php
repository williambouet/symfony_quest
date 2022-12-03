<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, [
            'label'    => 'Nom de la catégorie :',
            'required' => true,
            'attr' => [
                'class' => 'form-control my-2',
                'placeholder' => 'Tapez le nom de la nouvelle catégorie...',
            ],
            'help' => 'Ex : Drame, Espionnage, ...',
            'help_attr' => [
                'class' => 'text-secondary fw-light ',
            ],
            
        ]);

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }

}
