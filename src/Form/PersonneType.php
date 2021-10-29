<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Prenom',
                ],
                // 'constraints' => [
                //     new NotBlank([
                //         'message' => 'Please enter first name',
                //     ]),
                //     new Length([
                //         'min' => 3,
                //         'minMessage' => 'Your name should be at least {{ limit }} characters',
                //         // max length allowed by Symfony for security reasons
                //         'max' => 4096,
                //     ]),
                // ]
            ])
            ->add('lastName',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nom',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
             'translation_domain'=>'forms',

        ]);
    }
}