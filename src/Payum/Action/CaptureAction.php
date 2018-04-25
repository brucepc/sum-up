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
use BPCI\SumUp\Checkout\Checkout;
use Payum\Core\Request\Authorize;
use Payum\Core\Request\GetHttpRequest;

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
        
        $getHttpRequest = new GetHttpRequest();
        $this->gateway->execute($getHttpRequest);

        if ($getHttpRequest->method == 'POST') {
            $transaction = \GuzzleHttp\json_decode($getHttpRequest->request[$model['id']], true);
            $transaction = ArrayObject::ensureArrayObject($transaction['processing_result']);
            $model->replace($transaction);
        }

        if(!array_key_exists('status', $model)){
            $this->gateway->execute(new CreateCheckout($model));
        }
        
        if($model['status'] == Checkout::PENDING){
            if($model['card']){

            }else{
                $this->gateway->execute(new Authorize($model));
            }
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
            $request instanceof Capture
            && $request->getModel() instanceof \ArrayAccess;
    }

}