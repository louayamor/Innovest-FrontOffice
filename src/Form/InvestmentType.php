<?php

namespace App\Form;

use App\Entity\Business;
use App\Entity\Investment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class InvestmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Amount', null, [
            'constraints' => [
                new Regex([
                    'pattern' => '/^\d+$/',
                    'message' => 'Please enter a valid number.',
                ]),
            ],
        ])          
            ->add('Comment', null, [
                'label' => 'Comments (optional)',
                'required' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Investment::class,
        ]);
    }
}
