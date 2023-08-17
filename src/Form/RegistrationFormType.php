<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                "autocomplete" => false,
                "constraints" => [
                    new Regex([
                        "pattern" => "/^[a-zA-Z]{2,}$/",
                        "message" => "At least two letters, only letters are allowed"

                    ]),
                    new NotBlank([
                        'message' => 'Please enter a First Name',
                    ]),
                ],

            ])


            ->add('lastName', TextType::class, [
                "constraints" => [
                    new Regex([
                        "pattern" => "/^(?!.*\s{3})[a-zA-Z\s]{2,}$/",
                        "message" => "At least two letters, only letters are allowed"
                    ]),
                    new NotBlank([
                        'message' => 'Please enter a Last Name',
                    ]),
                ]
            ])


            ->add('dateOfBirth', DateType::class, [
                'label_attr' => [
                    "class" => "position-label date-input",
                ]
                ,
                'widget' => 'single_text',
                "constraints" => [
//                    new Callback([$this, "minAge"]) ,
                    new NotBlank([
                        "message" => "Please enter a Date"
                    ])
                ]
            ])


            ->add('email', EmailType::class, [
                "constraints" => [
                    new Email([]),
                    new Regex([
                        "pattern" => '/^[^@\t\r\n]+@[^@\t\r\n]+\.[^@\t\r\n]+$/',
                        "message" => "Email: At least 8 characters with at least one Capital letter,one Small letter,one Number and one Special Char"
                    ]),
                    new NotBlank([
                        'message' => 'Please enter an Email',
                    ]),
                ]
            ])


            ->add('gender', ChoiceType::class, [
                "choices" => [
                    "Male" => "male",
                    "Female" => "female"
                ],
                "label_attr" => [
                    "class" => "position-label gender-label"
                ]
                ,
                "constraints" => [
                    new NotBlank([
                        "message" => "Gender is Required"
                    ])
                ],
                "expanded" => "true",
                "data" => "male"
            ])


            ->add("address", AddressType::class)


            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])


            ->add('plainPassword', PasswordType::class, [
                // instead of being set into the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Regex([
                        "pattern" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                        "message" => "Password must be at least 8 characters with at least one uppercase letter, one lowercase letter, one digit, and one special character."
                    ])
                ],
                "label" => "Password"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function minAge($value, ExecutionContextInterface $context)
    {

        $dob = $value;

        $today = new DateTime();
        $minAgeDate = $today->modify('-18 years');
        //modify allows us to increment or decrement with the format strtotime()

        if ($dob > $minAgeDate) {
            $context->buildViolation('You must be at least 18 years old.')
                ->addViolation();
        }
    }
}
