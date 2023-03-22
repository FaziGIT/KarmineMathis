<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\Equipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('image')
            ->add('leJeu', EntityType::class, [
                // looks for choices from this entity
                'class' => Jeu::class,
                'placeholder' => 'Sélectionner le jeu concerné par l\'équipe',

                // uses the User.username property as the visible option string
                'choice_label' => 'nom',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,

                'attr'=>[
                    'class'=>"form-control form-custom-select white shadow-1",
                    // 'data-ax'=>"select",
                    'id'=>"custom-select-multiple",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
