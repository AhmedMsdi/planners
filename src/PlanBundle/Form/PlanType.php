<?php

namespace PlanBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $builder->add('idSc', EntityType::class, array(
            'class' => 'PlanBundle\Entity\SousCategorie',
            'choice_label' => 'libelle',
            'multiple' => false,
            'required' => true))
            ->add('libelle', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Titre')))
            ->add('adresse', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'adresse')))
            ->add('ville', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'ville')))
            ->add('image', FileType::class, array('attr' => array('class' => 'form-control', 'placeholder' => '')))
            //   ->add('email',TextType::class,array('attr'=>array('class'=>'form-control','placeholder'=>'email')))
            ->add('prix', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Titre')))
            ->add('longitude', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Titre')))
            ->add('latitude', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Titre')))
            ->add('description', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'description')));

    }

    /**
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
