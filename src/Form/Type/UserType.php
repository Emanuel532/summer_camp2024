<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nume', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3]),
                ],
            ])
            ->add('mail', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('parola', PasswordType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 6, 'minMessage' => 'Your password is too weak, try to add more characters!']),
                    new Assert\Regex([
                        'pattern' => '/[a-z]/',
                        'match' => true,
                        'message' => 'Your password should have at least one lowercase letter',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[A-Z]/',
                        'match' => true,
                        'message' => 'Your password should have at least one uppercase letter',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[0-9]/',
                        'match' => true,
                        'message' => 'Your password should contain at least one number',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[\W]/',
                        'match' => true,
                        'message' => 'Your password should have at least one special characte (for example: "$#@%&"r',
                    ]),
                ],
            ])
            ->add('birthday', BirthdayType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\LessThan([
                        'value' => '-13 years',
                        'message' => 'You must be at least 13 years old.',
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                    'Prefer not to say' => 'n',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
