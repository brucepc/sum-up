<?php

namespace BPCI\SumUp\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use BPCI\SumUp\SDK\Context;
use BPCI\SumUp\SDK\OAuth\AuthenticationHelper;

class DefaultController extends AbstractController
{
    private $context;

    public function __construct()
    {
        $this->context = Context::loadContextFromFile(\realpath(__DIR__.'/../../var/sumup.json'));
    }

    /**
     * @Route("/")
     */
    public function index(): Response{
        
        $oauthURI = AuthenticationHelper::getAuthorizationURL($this->context);
        return $this->render('index.html.twig', [
            'authorization_url' => $oauthURI
        ]);
    }

    /**
     * @Route("/token")
     */
    public function token(): Response{
        $tokenResponse = AuthenticationHelper::getAccessToken($this->context);
        return $this->render('token.html.twig', [
            'accessToken' => $tokenResponse
        ]);
    }
}