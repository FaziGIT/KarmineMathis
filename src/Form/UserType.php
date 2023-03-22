<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('email',TextType::class,['attr'=>[
        //     'class'=>'form-control',
        //     'type'=>'email',
        //     'data-form-validate'=>"auto",
        //     'required'=>true,
        //     'placeholder'=>"example@email.com"
        //     ]
        // ])
        ->add('nom',TextType::class,[
            'attr'=>[
                'autofocus'=>true,
                'placeholder'=>"Kebir"
            ]
        ])

        ->add('prenom',TextType::class,['attr'=>[
            'class'=>'form-control',
            'type'=>'email',
            'data-form-validate'=>"auto",
            'required'=>true,
            'placeholder'=>"Kamel"
            ]
        ])
        ->add('avatarFile',FileType::class,[
            'row_attr'=>[
                'class'=>'d-none'
            ],
            'attr'=>[
                'class'=>"btn primary rounded-1 shadow-1",
                'type'=>'file',
                'id'=>'img',
                'accept'=>'.jpg,.png'
            ],

            'constraints' => [
                new Image([
                    'maxSize' => '4000k',
                    'maxSizeMessage' => "L'image est trop volumineuse ({{ size }} {{ suffix }}). Le maximum autorisé est de {{ limit }} {{ suffix }}.",
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png'
                    ],
                    'mimeTypesMessage' => "L'extension du fichier est invalide ({{ type }}). Celles autorisés sont : {{ types }}"
                ])
            ],

            'mapped'=>false,
            'required'=>false,
            'label'=>"Ajouter un avatar"

        ])
        ->add('avatar',HiddenType::class)
        ->add('sexe', ChoiceType::class, [
            
            'choices'  => [
                'Homme <span class="iconify-inline font-s2" data-icon="mdi:face-man-shimmer-outline"></span>' => 1,
                'Femme <span class="iconify-inline font-s2" data-icon="mdi:face-woman-shimmer-outline"></span>' => 2,
            ],
            'attr'=>[
                'class'=>"form-control form-custom-select white shadow-1",
                'data-ax'=>"select",
                'id'=>"custom-select-multiple",
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
