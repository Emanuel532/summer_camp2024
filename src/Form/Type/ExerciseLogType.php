<?php
namespace App\Form\Type;

use App\Entity\Exercitii;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\ExerciseLog;

class ExerciseLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $exercises= [];
        foreach ($options['exercises'] as $tip ) {
            $exercises[$tip->getNume()] = $tip->getId();
        }

        $builder
            ->add('tip', ChoiceType::class, ['choices' => $exercises ])
            ->add('reps', IntegerType::class)
            ->add('duration', TimeType::class, [
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExerciseLog::class,
            'exercises' => null,
        ]);
    }
}
