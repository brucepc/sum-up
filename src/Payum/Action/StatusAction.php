<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 23/03/18
 * Time: 21:27
 */

namespace BPCI\SumUp\Payum\Action;


use BPCI\SumUp\Checkout\Checkout;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetStatusInterface;

/**
 * Class StatusAction
 * @package BPCI\SumUp\Payum\Action
 */
class StatusAction implements ActionInterface
{
    /**
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $model = ArrayObject::ensureArrayObject($request->getModel());

        if ($model['error'] || $model['status'] == Checkout::FAILED) {
            $request->markFailed();

            return;
        }

        if (false == $model['status']) {
            $request->markNew();

            return;
        }

        if ($model['status'] == Checkout::PENDING) {
            $request->markPending();

            return;
        }

        if ($model['status'] == Checkout::COMPLETED) {
            $request->markCaptured();

            return;
        }

        $request->markUnknown();
    }

    /**
     * @param GetStatusInterface $request
     * @return bool
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface
            && $request->getModel() instanceof \ArrayAccess;
    }
}