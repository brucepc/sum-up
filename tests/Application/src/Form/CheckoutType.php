<?php

namespace BPCI\SumUp\Tests\Form;

use BPCI\SumUp\Tests\Entity\Checkout;
use BPCI\SumUp\Tests\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use BPCI\SumUp\Utils\Currency;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('id', TextType::class,[
				'required' => false
			])
			->add('customer', TextType::class, [
				'property_path' => 'customer.customerId',
				'required' => false
			])
			->add('currency', ChoiceType::class, [
                'choices' => Currency::getCurrencies()
            ])
            ->add('amount')
            ->add('payToEmail')
            ->add('checkoutReference', TextType::class, [
            	'data' => uniqid() //change to your checkout id or cart id whatever
			])
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Checkout::class,
        ]);
    }
}
