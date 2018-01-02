<?php

namespace BPCI\SumUp\Tests\Form;

use App\Entity\Checkout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use BPCI\SumUp\Utils\Currency;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currency', ChoiceType::class, [
                'choices' => Currency::getCurrencies()
            ])
            ->add('amount')
            ->add('payToEmail')
            ->add('checkoutReference')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => Checkout::class,
        ]);
    }
}
