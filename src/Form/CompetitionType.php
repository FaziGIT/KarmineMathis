<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Competition;
use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=>"Nom de la compétition"
            ])
            ->add('Statut', ChoiceType::class, [
                'placeholder'=>"",
                'choices'  => [
                    'En cours' => 'En cours',
                    'Bientot' => 'Bientot',
                    'Fini' => 'Fini',
                ],
                'label'=>false,
            ])
            ->add('dateDebut', DateType::class, [
                'label'=>false,
                'widget' => 'choice',
                'attr'=>[
                    'style'=>'display:inline-flex;'
                ],
                'format' => 'ddMMMyyyy',
            ])
            ->add('gainPossible', IntegerType::class, [
                'label'=>"Gain possible de la compétition"
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'choice',
                'label'=>false,
                'attr'=>[
                    'style'=>'display:inline-flex;'
                ],
                'format' => 'ddMMMyyyy',
            ])
            ->add('equipe', EntityType::class, [
                'class'=>Equipe::class,
                'placeholder'=>'',
                'label'=>false,
                'multiple'=>false,
            ])
            ->add('lieu', EntityType::class, [
                'class'=>Lieu::class,
                'placeholder'=>'',
                'label'=>false,
                'multiple'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
        ]);
    }
}
