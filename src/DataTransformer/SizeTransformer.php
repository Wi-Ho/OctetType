<?php

namespace SizeType\Form\DataTransformer;

use SizeType\Form\Data\Size;
use Symfony\Component\Form\DataTransformerInterface;

class SizeTransformer implements DataTransformerInterface
{
    /**
     * @var bool
     */
    private $use_binary;

    /**
     * SizeTransformer constructor.
     *
     * @param bool $use_binary
     */
    public function __construct($use_binary)
    {
        $this->use_binary = $use_binary;
    }

    /**
     * @param int|null $value
     *
     * @return \SizeType\Form\Data\Size|null
     */
    public function transform($value)
    {
        $byte = new Size();
        if (null === $value) {
            return;
        }

        $unit = intval((log($value) / log($this->getExponent())));
        if ($unit > 6) {
            $unit = 6;
        }
        $byte->setUnit($unit);
        $byte->setValue($value / pow($this->getExponent(), $unit));

        return $byte;
    }

    /**
     * @param \SizeType\Form\Data\Size|null $value
     *
     * @return int|null
     */
    public function reverseTransform($value)
    {
        if (null === $value || null === $value->getValue()) {
            return;
        }

        return intval($value->getValue() * pow($this->getExponent(), $value->getUnit()));
    }

    /**
     * @return int
     */
    private function getExponent()
    {
        return true === $this->use_binary ? 1024 : 1000;
    }
}
