<?php

namespace App\Form;

use App\Entity\Business;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('Profit');
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


