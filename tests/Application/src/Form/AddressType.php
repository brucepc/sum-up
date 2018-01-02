<?php

namespace BPCI\SumUp\Tests\Form;

use BPCI\SumUp\Tests\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('line1')
            ->add('line2')
            ->add('country')
            ->add('postalCode')
            ->add('city')
            ->add('state')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Address::class,
        ]);
    }
}
