<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 12/03/18
 * Time: 14:28
 */

namespace BPCI\SumUp\Payum;


use BPCI\SumUp\Context;
use BPCI\SumUp\Payum\Action\Api\CreateCheckoutAction;
use BPCI\SumUp\Payum\Action\AuthorizeAction;
use BPCI\SumUp\Payum\Action\CaptureAction;
use BPCI\SumUp\Payum\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;
use BPCI\SumUp\Payum\Action\Api\RefundAction;

class SumUpGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults(
            [
                'payum.factory_name' => 'sumup_checkout',
                'payum.factory_title' => 'SumUp Checkout',

                'payum.template.authorize' => '@PayumSumUp/Action/authorize_card.html.twig',

                'payum.action.refund' => new RefundAction(),
                'payum.action.status' => new StatusAction(),
                'payum.action.capture' => new CaptureAction(),
                'payum.action.authorize' => function (ArrayObject $config) {
                    return new AuthorizeAction($config['payum.template.authorize']);
                },
                'payum.action.create_checkout' => new CreateCheckoutAction(),
                'payum.required_options' => ['pay_to_email'],
            ]
        );

        if (false == $config['payum.api']) {

            $config['payum.required_options'] = array_merge(
                $config['payum.required_options'],
                ['client_id', 'client_secret']
            );

            $config['payum.api'] = function (ArrayObject $config) {
                if (false == $config['client_credential']) {
                    $config->validateNotEmpty($config['payum.required_options']);
                    $context = new Context($config->toUnsafeArray());
                } else {
                    $context = Context::loadContextFromFile($config['client_credential']);
                }

                return new Api($config->toUnsafeArray(), $context);
            };

        }

        $config['payum.paths'] = array_replace(
            [
                'PayumSumUp' => __DIR__.'/Resources/views',
            ],
            $config['payum.paths'] ?: []
        );
    }

}