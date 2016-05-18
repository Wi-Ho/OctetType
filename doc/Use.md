How to use
==========

To use this form type, you just have to create your form type as describe on [the Symfony documentation](http://symfony.com/doc/current/book/forms.html).

Example using a form class that allows to limit input and output bandwidth:

```php
// src/AppBundle/Form/Type/BandwidthType.php
namespace AppBundle\Form\Type;

use SizeType\Form\Type\SizeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BandwidthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('input_bandwidth_limit', SizeType::class, [
                'label' => 'Input bandwidth limit',
                'use_binary' => true,
            ])
            ->add('output_bandwidth_limit', SizeType::class, [
                'label' => 'Output bandwidth limit',
                'use_binary' => true,
            ])
        ;
    }
}
```

> Note: when the option `use_binary` is set to `true` (default), the size is used with binary prefixes (power of 2 prefixes).
> If `false`, the size is used with SI prefixes.
> 
> See [this page for more details](https://en.wikipedia.org/wiki/Octet_(computing)#Unit_multiples).

The resulting data from a validated form is an integer:

* If you selected `123` and `kb` (SI prefix), the value will be `123000`.
* If you selected `456` and `Mib` (binary prefix), the value will be `478150656`.
