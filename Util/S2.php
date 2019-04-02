<?php

namespace Vctls\Select2EntityExtensionBundle\Util;

use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Shorthand class to build Select2 fields.
 */
class S2
{
    const OPT_CLASS = 'class';
    const OPT_DATA = 'data';
    const OPT_LABEL = 'label';
    const OPT_REQUIRED = 'required';
    const S2_CLASS = 'classname';
    const S2_REMOTE_ROUTE = 'remote_route';
    const S2_ROUTE_PARAMS = 'remote_params';
    const S2_MULTIPLE = 'multiple';
    const S2_PK = 'primary_key';
    const ROUTE = 'generic_autocomplete';

    /**
     * Return an array of arguments to pass to the $builder->add() method.
     *
     * @param string $field Name of the field
     * @param string $class Class name of the entity
     * @param bool $multiple Enable multiple selections
     * @param string $pk Name of the entity primary key
     * @param string $label Label of the field
     * @param bool $required Required field
     * @return array
     */
    public static function build($field, $class, $multiple = false, $pk = 'id', $label = null, $required = false)
    {
        return [$field, Select2EntityType::class, [
            self::OPT_CLASS => $class,
            self::S2_REMOTE_ROUTE => self::ROUTE,
            self::S2_ROUTE_PARAMS => [self::S2_CLASS => $class],
            self::S2_MULTIPLE => $multiple,
            self::S2_PK => $pk,
            self::OPT_LABEL => $label,
            self::OPT_REQUIRED => $required
        ]];
    }
}