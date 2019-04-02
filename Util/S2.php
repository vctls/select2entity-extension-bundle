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
     * @param $field
     * @param $class
     * @param bool $multiple
     * @param string $pk
     * @param null $label
     * @param bool $required
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