<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 23/03/18
 * Time: 21:44
 */

namespace BPCI\SumUp\Payum\Action;


use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\Authorize;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\RenderTemplate;

class AuthorizeAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;
    protected $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * @param Authorize $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $model = $request->getModel();

        $getHttpRequest = new GetHttpRequest();
        $this->gateway->execute($getHttpRequest);
//        if($getHttpRequest->method ==)

        $this->gateway->execute(
            $renderTemplate = new RenderTemplate(
                $this->template, [
                'model' => $model,
                'redirect_uri' => $request->getToken() ? $request->getToken()->getTargetUrl() : null,
            ]
            )
        );

        throw new HttpResponse($renderTemplate->getResult());
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