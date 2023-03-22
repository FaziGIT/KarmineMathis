<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('pseudo')
            ->add('sexe', ChoiceType::class, [
                'placeholder'=>"",
                'label'=>'Sexe',
                'choices'  => [
                    'Homme' => true,
                    'Femme' => false,
                ],
                'row_attr'=>[
                    'class'=>'d-flex'
                ]
            ])
            ->add('role', ChoiceType::class, [
                'choices'=>[
                    'CEO'=>'CEO',
                    'Joueur'=>'Joueur',
                ],
                'row_attr'=>[
                    'class'=>'d-flex'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'choice',
                'label'=>'Date de naissance',
                'attr'=>[
                    'style'=>'display:inline-flex;'
                ],
                'format' => 'ddMMMyyyy',
                'years' => range(date('Y'), date('Y')-100),
            ])
            ->add('nationalite')
            ->add('image', TextType::class, [
                'required'=>false,
            ])
            ->add('liquipedia', TextType::class, [
                'required'=>false,
            ])
            ->add('coach', EntityType::class, [
                'class'=>Equipe::class,
                'label'=>'de quel équipe',
                'row_attr' => [
                    'id' => 'coach-id',
                    'style' => 'display: none;', // masquer le champ Coach par défaut
                ],
                'required'=>false,
            ])
            ->add('joueur', EntityType::class, [
                'class'=>Equipe::class,
                'label'=>'de quel équipe',
                'row_attr' => [
                    'id' => 'joueur-id',
                    'style' => 'display: none;',
                ],
                'required'=>false,
            ])
            ->add('radioButton', ChoiceType::class, [
                'label'=>"Êtes vous : ",
                'choices'=>[
                    'aucun des deux'=>null,
                    'un Coach' => 'coach',
                    'un Joueur' => 'joueur',
                ],
                'expanded'=>true,
                'multiple'=>false,
                'mapped' => false,
                'required' => false,
                'placeholder'=>false,
                'row_attr' => [
                    'id' => 'radio-button-id',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
