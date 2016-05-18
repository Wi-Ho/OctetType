<?php

use SizeType\Form\Data\Size;
use SizeType\Form\Type\SizeType;
use Symfony\Component\Form\Test\TypeTestCase;

class SizeTypeTest extends TypeTestCase
{
    public function testSubmitValidDataUsingBinaryValue()
    {
        $form_data = [
            'unit'  => Size::UNIT_KB,
            'value' => 123,
        ];

        $form = $this->factory->create(SizeType::class);
        $object = new Size();
        $object->setValue(123);
        $object->setUnit(Size::UNIT_KB);

        $form->submit($form_data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(123 * 1024, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($form_data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitValidDataUsingSIValue()
    {
        $form_data = [
            'unit'  => Size::UNIT_KB,
            'value' => 123,
        ];

        $form = $this->factory->create(SizeType::class, null, ['use_binary' => false]);
        $object = new Size();
        $object->setValue(123);
        $object->setUnit(Size::UNIT_KB);

        $form->submit($form_data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(123 * 1000, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($form_data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitValidDataUsingEmptyValue()
    {
        $form_data = [
            'unit'  => Size::UNIT_KB,
            'value' => null,
        ];

        $form = $this->factory->create(SizeType::class);
        $object = new Size();
        $object->setValue(null);
        $object->setUnit(Size::UNIT_KB);

        $form->submit($form_data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(null, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($form_data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    /**
     * @dataProvider dataLoadData
     *
     * @param int  $value
     * @param bool $use_binary
     * @param int  $expected_value
     * @param int  $expected_unit
     */
    public function testLoadFromValue($value, $use_binary, $expected_value, $expected_unit)
    {
        $form = $this->factory->create(SizeType::class, $value, ['use_binary' => $use_binary]);
        $this->assertEquals($value, $form->getData());
        $this->assertInstanceOf(Size::class, $form->getNormData());
        $this->assertEquals($expected_value, $form->getNormData()->getValue());
        $this->assertEquals($expected_unit, $form->getNormData()->getUnit());
    }

    public function dataLoadData()
    {
        return [
            [
                123,
                true,
                123,
                Size::UNIT_B,
            ],
            [
                1024,
                true,
                1,
                Size::UNIT_KB,
            ],
            [
                1024 * 1024,
                true,
                1,
                Size::UNIT_MB,
            ],
            [
                1024 * 1024,
                false,
                1.048576,
                Size::UNIT_MB,
            ],
            [
                1000 * 1000,
                false,
                1,
                Size::UNIT_MB,
            ],
            [
                123000,
                false,
                123,
                Size::UNIT_KB,
            ],
            [
                1230000,
                false,
                1.23,
                Size::UNIT_MB,
            ],
            [
                100000000 * pow(1000, Size::UNIT_EB),
                false,
                100000000,
                Size::UNIT_EB,
            ],
            [
                null,
                false,
                null,
                Size::UNIT_B,
            ],
        ];
    }
}
