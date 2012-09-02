<?php

namespace MQM\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use MQM\UserBundle\Model\UserInterface;
use MQM\UserBundle\Form\DataTransformer\UsernameTransformer;
use MQM\UserBundle\Form\Type\Helper;

class StaffRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'repeated', array(
                'type' => 'email',
                'invalid_message' => 'Passwords have to be equal.',
                'first_name' => 'email',
                'second_name' => 're-enter_email',
                'required' => true,
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Passwords have to be equal.',
                'first_name' => 'password',
                'second_name' => 're-enter_password',
                'required' => Helper::getInstance()->existsValidationGroupNameInOptions('StaffRegistration', $options),
            ))
            ->add('permissionType', 'choice', array(
                'choices' => $this->buildPermissionsTypeChoice($builder)
            ))
            ->addModelTransformer(new UsernameTransformer())
        ;
    }

    private function buildPermissionsTypeChoice($builder)
    {
        $permissionsType = array();
        $data = $builder->getData();
        if ($data) {
            $permissionType = $data->getPermissionType();
            $permissionsType[$permissionType] = ' - ';
        }
        $permissionsType[UserInterface::ROLE_ADMIN] = 'Administrador';
        $permissionsType[UserInterface::ROLE_STAFF] = 'Staff';
        $permissionsType[UserInterface::ROLE_BASIC_STAFF] = 'Staff básico';

        return $permissionsType;
    }

    public function getName()
    {
        return 'mqm_user_form_type_registration_staff';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MQM\UserBundle\Entity\User',
        );
    }
}
