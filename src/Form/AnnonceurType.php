<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Titre'
                ]
            ])
            ->add('price',NumberType::class,[
                'attr'=>[
                    'placeholder'=>'Prix'
                ]
            ])
            ->add('content',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Descrire au mieux votre annonce'
                ]
            ])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'name'
                ])
            // ->add('etat',ChoiceType::class,[
            //     'choices'=>Annonce::etats
            // ])
            ->add('images',FileType::class,[
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
