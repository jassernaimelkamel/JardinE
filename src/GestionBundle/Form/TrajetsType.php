<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TrajetsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', null, array(
                'required'      => true,
            ))
            ->add('locality',HiddenType::class, array(
                'required'      => false,
            ))
            ->add('country', HiddenType::class, array(
                'required'      => false,
            ))
            ->add('lat', HiddenType::class, array(
                'required'      => false,
            ))
            ->add('lng', HiddenType::class, array(
                'required'      => false,
            ));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\Trajets'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_trajets';
    }


}
