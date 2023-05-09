<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Model\FiltreCompetition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltreCompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lieu', EntityType::class, [
            'class'=>Lieu::class,
            'choice_label'=>'getNomComplet',
            'placeholder'=>"",
            'label'=>'Choisir un lieu',
            'required'=>false,
            'attr'=> [
                'data-placeholder'=>'Recherche un lieu'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method'=>'get',
            'csrf_protection'=>false,
            'data_class'=>FiltreCompetition::class
        ]);
    }
}
