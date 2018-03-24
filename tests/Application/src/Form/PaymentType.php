<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 20/03/18
 * Time: 21:15
 */

namespace BPCI\SumUp\Tests\Form;


use BPCI\SumUp\Utils\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class)
            ->add(
                'currency',
                ChoiceType::class,
                [
                    'choices' => Currency::getCurrencies(),
                    //The test account is from brazil.
                    'preferred_choices' => [
                        'BRL',
                    ],
                ]
            )
            ->add(
                'checkout_reference',
                TextType::class,
                [
                    'data' => uniqid(),
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    'data' => 'Test SumUp API',
                ]
            );
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefault('data_class', Payment::class);
//    }

}