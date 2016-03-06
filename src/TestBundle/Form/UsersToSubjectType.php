<?php

namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersToSubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Predmet',
                'attr' => array('class' => 'form-control'),
                'read_only' => true,
            ))
            ->add('users', 'entity', array(
                'class' => 'TestBundle\Entity\User',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Vyberte žiakov (výber viac cez tlačidlo Ctrl)',
                'attr' => array('class' => 'form-control')
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TestBundle\Entity\Subject',
            ''
        ));
    }

    public function getName()
    {
        return 'test_bundle_users_to_subject_type';
    }
}
