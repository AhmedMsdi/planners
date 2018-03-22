<?php

namespace PlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('libelle',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'Titre')))
            ->add('adresse',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'adresse')))
            ->add('description',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'description')))
            ->add('ville',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'ville')))
            ->add('image',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'')))
            ->add('email',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'email')))
            ->add('prix',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'prix')))
            ->add('longitude',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'longitude')))
            ->add('latitude',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'latitude')))
            ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanBundle\Entity\Plan'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planbundle_plan';
    }


}
