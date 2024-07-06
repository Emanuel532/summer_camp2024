<?php
namespace App\Form\Type;

use App\Entity\Workout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutType extends AbstractType
{


    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $users = $options['users'];
        $exercises = $options['exercises'];
        $tipuri = $options['tipuri'];



        $builder
            ->add('nume', TextType::class)
            ->add('users', ChoiceType::class, [
                'choices' => $users,
                'choice_label' => 'nume'
            ])
            ->add('date', DateType::class)
            ->add('tip', ChoiceType::class, [
                'choices' => $tipuri,
                'choice_label' => 'nume'
            ])
            ->add('exerciseLogs', CollectionType::class, [
                'entry_type' => null,
                'entry_options' => [
                    'label' => false,
                ],
                'prototype_data'=> $exercises,
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Exercises'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'users' => null,
            'exercises' => null,
            'tipuri' => null,
        ]);
    }
}
