<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 15/03/18
 * Time: 20:28
 */

namespace BPCI\SumUp\Payum\Action\Api;


use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Payum\Api as API;
use BPCI\SumUp\Payum\Request\Api\CreateCheckout;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\ApiAwareTrait;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;

/**
 * Class CreateCheckoutAction
 * @package BPCI\SumUp\Payum\Action\Api
 * @property API $api
 */
class CreateCheckoutAction implements ActionInterface, ApiAwareInterface, GatewayAwareInterface
{
    use ApiAwareTrait;
    use GatewayAwareTrait;

    public function __construct()
    {
        $this->apiClass = API::class;
    }

    /**
     * @param mixed $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        /** @var $request CreateCheckout */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());
        try {
            $checkout = $this->api->createCheckout($model->toUnsafeArray());
            $model->replace($checkout);
        } catch (BadRequestException $e) {
            $model->replace(['error' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof CreateCheckout
            && $request->getModel() instanceof \ArrayAccess;
    }
}
