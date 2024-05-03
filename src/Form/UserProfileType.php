<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserProfile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', null, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 255]), 
                ],
            ])
            ->add('LastName', null, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 255]), 
                ],
            ])
            ->add('PhoneNumber', IntegerType::class, [
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{10}$/', 
                        'message' => 'Please enter a valid phone number.', 
                    ]),
                ],
            ])
            ->add('Age', IntegerType::class, [
                'required' => false,
                'constraints' => [
                    new Range(['min' => 1, 'max' => 150]), 
                ],
            ])
            ->add('Country', ChoiceType::class, [
                'required' => false,
                'choices' => $options['countries'] ?: [],
                'placeholder' => 'Select a country',
                'choice_label' => function ($value) {
                    return $value;
                },
                
            ])
            ->add('ProfileImage', FileType::class, [
                'required' => false,
                'constraints' => [  
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPEG or PNG image.', 
                    ]),
                ],
            ])
            ->add('Gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('Bio', TextareaType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-success',
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
            'countries' => require __DIR__.'/../uses/countries.php',
        ]);
    }
}