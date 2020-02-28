<?php

namespace ActiviteBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ActiviteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo',FileType::class, array('data_class'=>null, 'required'=>false))
            ->add('nomActivite')->add('dateActivite')->add('timeStart')->add('timeEnd')->add('description')
            ->add('animateur',EntityType::class,array(
                'class'=>'ActiviteBundle:Animateur',
                'choice_label'=>'id',
                'multiple'=>false
            ))
            ->add('categorie',EntityType::class,array(
                'class'=>'ActiviteBundle:categorie',
                'choice_label'=>'id',
                'multiple'=>false
            ));

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ActiviteBundle\Entity\Activite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'activitebundle_activite';
    }


}
