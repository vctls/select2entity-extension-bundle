# Vctls Select2Entity Extension Bundle

This bundle provides helpers for working with Tetranz Select2EntityBundle.

`Searcher` classes define configuration for the entities used in Select2 fields.

## Configuration

Add routing to the default controller:
```yaml
# routes.yml
vctls_select2_entity_extension:
    resource: '@VctlsSelect2EntityExtensionBundle/Resources/config/routing.yaml'
```

Add the namespace of your `Searcher` classes in `config.yml`. Default is `App\Util`:
```yaml
# config.yml
vctls_select2_entity_extension:
    searcher_namespace: 'AppBundle\Tool\Select2\'
```

## Creating Select2 fields:

First, create a `Searcher` class for the entity you want to use in your field.

```php
<?php

namespace App\Util;

class ExampleSearcher extends Searcher
{
    public $alias = 'example';
    public $idMethod = 'getId';
    public $textMethod = '__toString';
    public $searchfileds = ['example.name'];
}
```

Then, add a Select2 field in your form:

```php
<?php

namespace App\Form\Example;

use App\Entity\Example;
use Vctls\Select2EntityExtensionBundle\Util\S2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ExampleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // with the helper class...
        $builder->add(...S2::build('example', Example::class));
        
        // or without it
        $builder->add('example2', Select2EntityType::class, [
            'remote_route' => 'generic_autocomplete',
            'remote_params' => [
                'classname' => Example::class
            ],
            'class' => Example::class,
            'primary_key' => 'id',
            'text_property' => 'name',
            'minimum_input_length' => 2,
            'delay' => 250,
            'cache' => true,
            'placeholder' => 'Select an example',
        ]);
    }
}
```

## Secure access to the default controller

