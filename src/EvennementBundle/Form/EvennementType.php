<?php

namespace EvennementBundle\Form;

use PiBundle\PiBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EvennementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('adresse')->add('ville')->add('date_event')->add('time_event')->add('description')->add('image')->add('prix')->add('contact')
            ->add('CatEvent', EntityType::class, array(
                'class' => 'EvennementBundle:CategorieEvent',
                'choice_label' => 'libelle',
            ))
            ->add('User', EntityType::class, array(
                'class' => 'PiBundle:User',
                'choice_label' => 'nom',
            ))
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
