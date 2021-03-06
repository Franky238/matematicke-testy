<?php

namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", 'text', array(
                'label' => 'Názov',
                'attr' => array('class' => 'form-control', 'placeholder' => 'Názov...')
            ))
            ->add('file', 'file', array(
                'label' => 'Test',
                'attr' => array('class' => 'form-control')
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'test_bundle_test_upload_type';
    }
}
