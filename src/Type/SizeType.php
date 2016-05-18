<?php

namespace SizeType\Form\Type;

use SizeType\Form\Data\Size;
use SizeType\Form\DataTransformer\SizeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SizeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = $this->getChoices($options['use_binary']);
        $builder
            ->add('value', NumberType::class, [
                'required' => false,
                'label'    => false,

            ])
            ->add('unit', ChoiceType::class, [
                'required' => true,
                'choices'  => $choices,
            ])
            ->addModelTransformer(new SizeTransformer($options['use_binary']));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Size::class,
            'use_binary' => true,
        ]);
        $resolver->addAllowedTypes('use_binary', 'bool');
    }

    private function getChoices($use_binary)
    {
        if (true === $use_binary) {
            return [
                'b'   => Size::UNIT_B,
                'kib' => Size::UNIT_KB,
                'Mib' => Size::UNIT_MB,
                'Gib' => Size::UNIT_GB,
                'Tib' => Size::UNIT_TB,
                'Pib' => Size::UNIT_PB,
                'Eib' => Size::UNIT_EB,
            ];
        }

        return [
            'b'  => Size::UNIT_B,
            'kb' => Size::UNIT_KB,
            'Mb' => Size::UNIT_MB,
            'Gb' => Size::UNIT_GB,
            'Tb' => Size::UNIT_TB,
            'Pb' => Size::UNIT_PB,
            'Eb' => Size::UNIT_EB,
        ];
    }
}
