<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BMIType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('weight', NumberType::class, [
            'required' => true,
        ])->add('height', NumberType::class, [
            'required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
