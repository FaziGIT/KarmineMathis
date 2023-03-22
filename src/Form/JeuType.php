<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\CategorieJeu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('image')
            ->add('description')
            ->add('lesCategories', EntityType::class, [
                // looks for choices from this entity
                'class' => CategorieJeu::class,

                'attr' => [
                    'data-placeholder' => 'Sélectionner une/des catégories'
                ],
                'by_reference' => false,

                // uses the User.username property as the visible option string
                'choice_label' => 'libelle',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                // 'expanded' => true,

                // 'attr'=>[
                //     'class'=>"form-control form-custom-select white shadow-1",
                //     // 'data-ax'=>"select",
                //     'id'=>"custom-select-multiple",
                // ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
