<?php

namespace MQM\UserBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use MQM\UserBundle\Model\UserFactoryInterface;
use Symfony\Component\Form\Form;

class UserRegistrationFormHandler
{
    protected $request;
    protected $encoderFactory;
    protected $userFactory;
    protected $form;
    protected $currentPassword;

    public function __construct(Request $request, EncoderFactoryInterface $encoderFactory, UserFactoryInterface $userFactory)
    {
        $this->request = $request;
        $this->encoderFactory = $encoderFactory;
        $this->userFactory = $userFactory;
    }

    public function process(Form $form)
    {
        $this->form = $form;
        $this->initialize();
        if ('POST' === $this->request->getMethod()) {
            $this->form->bindRequest($this->request);

            if ($this->form->isValid()) {
                $this->setNewPasswordToUserIfChanged();

                return true;
            }
        }

        return false;
    }

    private function initialize()
    {
        if ($this->getUser()) {
            $this->currentPassword = $this->getUser()->getPassword();
        }
        else {
            $user = $this->userFactory->createUser();
            $this->form->setData($user);
        }
    }

    private function getUser(){
        return $this->form->getData();
    }

    private function setNewPasswordToUserIfChanged()
    {
        $user = $this->getUser();
        $newPassword = $user->getPassword();
        if ($newPassword !=null && count(trim($newPassword)) > 0) {
            $this->encodeUserPassword();
        }
        else {
            $user->setPassword($this->currentPassword);
        }
    }

    private function encodeUserPassword()
    {
        $user = $this->getUser();
        $factory = $this->encoderFactory;
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($password);

        return $password;
    }
}