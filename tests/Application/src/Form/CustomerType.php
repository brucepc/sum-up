<?php

namespace BPCI\SumUp\Tests\Form;

use BPCI\SumUp\Tests\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customerId', TextType::class, [
                'required' => false
            ])
            ->add('name', TextType::class)
            ->add('cpfCnpj')
            ->add('phone')
            ->add('address', AddressType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
