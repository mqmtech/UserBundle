<?php

namespace MQM\UserBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use MQM\UserBundle\Model\UserManagerInterface;
use MQM\UserBundle\Model\UserInterface;

class UniqueValidator extends ConstraintValidator
{
    private $userManager;
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof UserInterface) {
            throw new UnexpectedTypeException($value, 'MQM\UserBundle\Model\UserInterface');
        }

        $property = $constraint->property;
        $isUnique = $this->userManager->validateUnique($value, $property);
        if ($isUnique == false) {
            $this->context->addViolation($constraint->message, array(
                '%property%' => $constraint->property,
            ));
        }
    }
}
