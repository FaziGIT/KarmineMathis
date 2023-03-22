<?php

namespace App\Form;

use App\Entity\CategorieJeu;
use App\Entity\Jeu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieJeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            // ->add('lesJeux', EntityType::class, [
            //     // looks for choices from this entity
            //     'class' => Jeu::class,

            //     // uses the User.username property as the visible option string
            //     'choice_label' => 'nom',

            //     // used to render a select box, check boxes or radios
            //     'multiple' => true,
            //     // 'expanded' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieJeu::class,
        ]);
    }
}
