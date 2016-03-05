<?php

namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", 'text', array(
                'label' => 'Názov',
                'attr' => array('class' => 'form-control', 'placeholder' => 'Názov...')
            ))
            ->add('tests', 'entity', array(
                'class' => 'TestBundle\Entity\Test',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Priraď testy (výber viac cez tlačidlo Ctrl)',
                'attr' => array('class' => 'form-control')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'test_bundle_subject_add_type';
    }
}