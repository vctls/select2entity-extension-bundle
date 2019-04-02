<?php

namespace Vctls\Select2EntityExtensionBundle\Util;


class ExampleSearcher extends Searcher
{
    public $alias = 'example';
    public $idMethod = 'getId';
    public $textMethod = '__toString';
    public $searchfileds = ['example.name'];
}