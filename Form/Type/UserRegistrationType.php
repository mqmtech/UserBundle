<?php

namespace MQM\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use MQM\UserBundle\Form\DataTransformer\UsernameTransformer;
use MQM\UserBundle\Form\Type\Helper;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array(
                'required' => true,
            ))
            ->add('lastName', null, array(
                'required' => true,
            ))
            ->add('address', null, array(
                'required' => true
            ))
            ->add('email', 'repeated', array(
                'type' => 'email',
                'invalid_message' => 'Emails have to be equal.',
                'first_name' => 'email',
                'second_name' => 're-enter_email',
                'required' => true,
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Passwords have to be equal.',
                'first_name' => 'password',
                'second_name' => 're-enter_password',
                'required' => Helper::getInstance()->existsValidationGroupNameInOptions('Registration', $options),
            ))
            ->add('firmName', null, array(
                'required' => true,
            ))
            ->add('vatin', null, array(
                'required' => true,
            ))
            ->add('zipCode', null, array(
                'required' => true,
            ))
            ->add('city', null, array(
                'required' => true,
            ))
            ->add('province', null, array(
                'required' => true,
            ))
            ->add('phone', null, array(
                'required' => true,
            ))
            ->add('fax')
            ->addModelTransformer(new UsernameTransformer())
        ;
    }

    public function getName()
    {
        return 'mqm_user_form_type_registration_client';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MQM\UserBundle\Entity\User',
        );
    }
}
