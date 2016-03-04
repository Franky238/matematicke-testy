<?php

namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name")
            ->add("surname")
            ->add("username")
            ->add('password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm-password',
            'type' => 'password'
        ))
        ->add("button", "submit")
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'test_bundle_user_add_type';
    }
}
