<?php

namespace EvennementBundle\Form;

use PiBundle\PiBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityRepository;

class EvennementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre',TextType::class,[
            'label'=>'Titre',
            'required'=>false,
            'attr'=>[
                'placeholder'=>'Titre',
                'autocomplete'=>'off'
            ]

        ])
            ->add('adresse',TextType::class,[
                'label'=>'Adresse',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Adresse',
                    'autocomplete'=>'off'
                ]

            ])
            ->add('ville',TextType::class,[
                'label'=>'Ville',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Ville',
                    'autocomplete'=>'off'
                ]

            ])
            ->add('date_event', DateType::class, [
                'label' => "Date",
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => "Date",
                    'class' => 'datepicker']
            ])
            ->add('time_event',TimeType::class,[
                'label'=>'Heure',
                'required'=>false,
                'widget' => 'single_text',
                'attr'=>[
                    'placeholder'=>'Heure',
                    'autocomplete'=>'off'
                ]

            ])
            ->add('description',TextareaType::class,[
                'label'=>'Description',
                'required'=>false,
                'attr'=>[
                    'rows'=>'10',
                    'style'=>"resize: none;"
                ]

            ])
            ->add('image',FileType::class,[
                'label'=>'Image',
                'required'=>false

            ])
            ->add('prix',TextType::class,[
                'label'=>'Prix',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Prix',
                    'autocomplete'=>'off'
                ]

            ])
            ->add('contact',TextType::class,[
                'label'=>'Contact',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Contact',
                    'autocomplete'=>'off'
                ]

            ])
            ->add('CatEvent', EntityType::class, [
                "required" => false,
                'class' => 'EvennementBundle:CategorieEvent',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.libelle', 'ASC');
                },
                'placeholder' => 'Tous',
                'label' => 'Catégorie',
                'choice_label' => 'libelle'
            ])

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvennementBundle\Entity\Evennement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evennementbundle_evennement';
    }


}
