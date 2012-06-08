<?php

namespace MQM\UserBundle\Form\Type;

class Helper
{
    private static $instance = null;

    /**
     * @static
     * @return Helper
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Helper();
        }

        return self::$instance;
    }

    public function existsValidationGroupNameInOptions($validationGroupName, array $options = null)
    {
        if (!$options)
            $options = $this->options;

        if (!$options)
            return false;

        if (!isset($options['validation_groups']))
            return false;

        $validationGroups = $options['validation_groups'];
        foreach ($validationGroups as $validationGroup) {
            if ($validationGroup == $validationGroupName) {
                return true;
            }
        }

        return false;
    }
}
