<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 15/03/18
 * Time: 19:17
 */

namespace BPCI\SumUp\Payum\Action;


use BPCI\SumUp\Payum\Request\Api\CreateCheckout;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Capture;

class CaptureAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;


    /**
     * @param Capture $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        if ($model['status']) {
            return;
        }
        $this->gateway->execute(new CreateCheckout($model));
//        $this->gateway->execute(new Sync($model));
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof Capture
            && $request->getModel() instanceof \ArrayAccess;
    }

}