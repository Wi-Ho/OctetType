<?php

namespace SizeType\Form\Data;

class Size
{
    const UNIT_B = 0;
    const UNIT_KB = 1;
    const UNIT_MB = 2;
    const UNIT_GB = 3;
    const UNIT_TB = 4;
    const UNIT_PB = 5;
    const UNIT_EB = 6;
    /**
     * @var int|null
     */
    private $value;

    /**
     * @var int
     */
    private $unit;

    /**
     * @return int|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int|null $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param int $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }
}
