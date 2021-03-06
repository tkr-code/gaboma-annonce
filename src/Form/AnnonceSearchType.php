<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\AnnonceSearch;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AnnonceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots',SearchType::class,[
                'label'=>false,
                'attr'=>[
                    'id'=>'searchBox',
                    'class'=>'form-primary rounded s text-lowercase',
                    'placeholder'=>'Enter one or more keywords'
                ],
                'required'=>false
            ])
            ->add('maxPrice',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Maximum budget',
                    'class'=>'form-primary'
                ]
            ])
            ->add('minPrice',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Minimum budget',
                    'class'=>'form-primary'
                ]
            ])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                // 'query_builder'=>function(EntityRepository $entityRepository){
                //     return $entityRepository->createQueryBuilder('p')
                //     ->where('p.is_active = true');
                // },
                'choice_label'=>'name',
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'class'=>'form-primary',  
                ],
                'placeholder'=>'Toutes les annonces'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnnonceSearch::class,
            'method'=>'get',
            'csrf_protection'=>false,
            'translation_domain'=>'forms',

        ]);
    }
   public function getBlockPrefix(){
        return '';
    }
}