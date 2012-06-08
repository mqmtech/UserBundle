<?php

namespace MQM\UserBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use MQM\UserBundle\Model\UserInterface;

class UsernameTransformer implements DataTransformerInterface
{
    public function transform($val)
    {
        if (null === $val) {
            return '';
        }

        return $val;
    }

    public function reverseTransform($val)
    {
        if (!$val) {
            return null;
        }
        if (!$val instanceof \MQM\UserBundle\Model\UserInterface) {
            throw new TransformationFailedException('UsernameTransformer expected a UserInterface object');
        }
        $this->copyEmailToUsername($val);

        return $val;
    }

    private function copyEmailToUsername(UserInterface $user)
    {
        if (!$user->getUsername() || trim($user->getUsername()) == '') {
            $email = $user->getEmail();
            $user->setUsername($email);
        }
    }
}
