<?php
namespace App\Form\Type;

use App\Entity\Workout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $tipuri= [];
    $users = $options['users'];
    foreach ($options['tipuri'] as $tip ) {
        $tipuri_id[] = $tip->getId();
        $tipuri_nume[] = $tip->getNume();
        $tipuri[$tip->getNume()] = $tip->getId();
    }

    $builder
        ->add('nume', TextType::class)
        ->add('users', ChoiceType::class, ['choices' => $users])
        ->add('date', DateType::class)
        ->add('tip', ChoiceType::class, ['choices' => $tipuri ]);

}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
    'data_class' => null,
        'tipuri' => null,
        'users' => null,
    ]);
    }
}
