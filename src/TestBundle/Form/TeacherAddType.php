<?php

namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", "text", array(
                'label' => 'Meno',
                'attr' => array('class' => 'form-control', 'placeholder' => 'Meno...')
            ))
            ->add("surname", "text", array(
                'label' => 'Priezvisko',
                'attr' => array('class' => 'form-control', 'placeholder' => 'Priezvisko...')
            ))
            ->add("username", "text", array(
                'label' => 'Tuke identifikátor',
                'attr' => array('class' => 'form-control', 'placeholder' => 'Tuke identifikátor...')
            ))
            ->add('password', 'repeated', array(
                'first_options'  => array(
                    'label' => 'Heslo',
                    'attr' => array('class' => 'form-control', 'placeholder' => 'Heslo...')

                ),
                'second_options' => array(
                    'label' => 'Zopakuj heslo',
                    'attr' => array('class' => 'form-control', 'placeholder' => 'Zopakuj heslo...')
                ),
                'type' => 'password',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'test_bundle_teacher_add_type';
    }
}
