<?php

namespace HebergementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HebergementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categorie', ChoiceType::class, array
        ('choices'=> array(
            'Hôtel'=>'Hôtel',
            'Maison_d\'hôte'=>'Maison_d\'hôte',
            'Pensions'=>'Pensions',
        )
        ))
            ->add('lieu')
            ->add('description')
            ->add('prix')
            ->add('tel')
            ->add('siteWeb');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HebergementBundle\Entity\Hebergement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hebergementbundle_hebergement';
    }


}
