<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 31/03/18
 * Time: 07:40
 */

namespace BPCI\SumUp\Tests\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'filters',
            CollectionType::class,
            [
                'allow_add' => true,
            ]
        );
    }

}