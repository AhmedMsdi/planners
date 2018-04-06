<?php

namespace HebergementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\UrlTypeTest;
use Symfony\Component\HttpFoundation\File\File;
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
            ->add('photo',FileType::class, array(
                'required' => false,
                'data_class'=>null,
            ))
            ->add('titre',TextType::class)
            ->add('lieu',TextType::class)
            ->add('x',NumberType::class,array(
                'scale'=>15
            ))
            ->add('y',NumberType::class,array(
                'scale'=>15
            ))
            ->add('description',TextareaType::class)
            ->add('prix',NumberType::class)
            ->add('tel',NumberType::class,
                array ('attr'=>array('min'=>8)))
            ->add('siteWeb',UrlType::class);
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
