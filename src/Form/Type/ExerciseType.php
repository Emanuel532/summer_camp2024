<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Exercitii;
use App\Repository\TipRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //dd($options['data']);
        $tipuri= [];
        foreach ($options['data'] as $tip ) {
            $tipuri_id[] = $tip->getId();
            $tipuri_nume[] = $tip->getNume();
            $tipuri[$tip->getNume()] = $tip->getId();
        }



        $builder
            ->add('nume', TextType::class)
            ->add('link_video', TextType::class)
            ->add('tip', ChoiceType::class, ['choices' => $tipuri ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }

}
