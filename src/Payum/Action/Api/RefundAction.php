<?php

namespace BPCI\SumUp\Payum\Action\Api;

use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Payum\Api as API;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\ApiAwareTrait;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Refund;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;

class RefundAction implements ActionInterface, ApiAwareInterface, GatewayAwareInterface
{
    use ApiAwareTrait;
    use GatewayAwareTrait;

    public function __construct()
    {
        $this->apiClass = API::class;
    }

    /**
     * Execute action
     *
     * @param Request $request
     * @return void
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());
        $transaction = $this->api->refund($model->toUnsafeArray());
    }

    /**
     * {@inheritDoc}
     *
     * @param Refund $request
     * @return void
     */
    public function supports($request)
    {
        return 
            $request instanceof Refund
            && $request->getModel() instanceof \ArrayAccess;
    }
}