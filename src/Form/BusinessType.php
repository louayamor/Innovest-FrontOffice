<?php

namespace App\Form;

use App\Entity\Business;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class BusinessType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Description')
            ->add('Sector', ChoiceType::class, [
                'choices' => $options['sector_choices'],
                'placeholder' => 'Select a sector',
                'label' => 'Sector',
                'required' => true, 
            ])
            ->add('Country', ChoiceType::class, [
                'choices' => $options['countries'] ?: [], 
                'placeholder' => 'Select a country',
                'choice_label' => function ($value) {
                    return $value;
                },
            ])
            ->add('Revenue')
            ->add('Profit')

            ->add('ImageBlob', FileType::class, [
                'required' => false,
                'constraints' => [  
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPEG or PNG image.', // Custom error message
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Business::class,
            'sector_choices' => [],
            'countries' => require __DIR__.'/../uses/countries.php',
        ]);
    }
}


