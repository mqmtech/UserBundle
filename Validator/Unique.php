<?php

namespace MQM\UserBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Unique extends Constraint
{
    public $message = 'The value for the property %property% already exists';
    public $property;

    public function getDefaultOption()
    {
        return 'property';
    }

    public function getRequiredOptions()
    {
        return array('property');
    }

    public function validatedBy()
    {
        return 'mqm_user.validator.unique';
    }

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}