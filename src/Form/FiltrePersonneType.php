<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Model\FiltrePersonne;
use App\Repository\EquipeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltrePersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'=>[
                    'placeholder'=>'Saisir une partie du nom de la personne',
                ],
                'required'=>false,
                'label'=>'Recherche sur le nom',
            ])
            ->add('coach', EntityType::class, [
                'class'=>Equipe::class,
                'query_builder'=>function(EquipeRepository $repo){
                        return $repo->listeEquipeSimple();
                },
                'choice_label'=>'nom',
                'placeholder'=>"",
                'label'=>'Recherche sur le coach de l\'équipe',
                'required'=>false,
            ])
            ->add('joueur', EntityType::class, [
                'class'=>Equipe::class,
                'query_builder'=>function(EquipeRepository $repo){
                        return $repo->listeEquipeSimple();
                },
                'choice_label'=>'nom',
                'placeholder'=>"",
                'label'=>'Recherche sur le joueur de l\'équipe',
                'required'=>false,
            ])
            ->add('lesEquipes', EntityType::class, [
                'class'=>Equipe::class,
                'query_builder'=>function(EquipeRepository $repo){
                        return $repo->listeEquipeSimple();
                },
                'choice_label'=>'nom',
                'by_reference' => false,
                'multiple'=>true,
                'label'=>'Choisir un coach',
                'required'=>false,
                'attr'=> [
                    'data-placeholder'=>'Recherche un/des coachs'
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
            'data_class'=>FiltrePersonne::class
        ]);
    }
}
