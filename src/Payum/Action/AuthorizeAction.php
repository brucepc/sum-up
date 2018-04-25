<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 23/03/18
 * Time: 21:44
 */

namespace BPCI\SumUp\Payum\Action;


use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\Authorize;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\RenderTemplate;

/**
 * Class ConvertPaymentAction
 * @package BPCI\SumUp\Payum\Action
 * @property $gateway Payum\Core\GatewayInterface
 * {@inheritdoc}
 */
class AuthorizeAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;
    protected $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * @param Convert $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $model = ArrayObject::ensureArrayObject($request->getModel());
        
        $renderTemplate = new RenderTemplate(
            $this->template, [
                'checkout_id' => $model['id'],
            ]
        );

        $this->gateway->execute($renderTemplate);

        throw new HttpResponse($renderTemplate->getResult(), 401);
    }

    /**
     * @param Authorize $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof Authorize
            && $request->getModel() instanceof \ArrayAccess;
    }
}