<?php

namespace BPCI\SumUp\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use BPCI\SumUp\Context;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\Tests\Entity\Customer;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
    
    /**
     * @Route("/customer")
     */
    public function createCustomer(): Response {
        $customer = new Customer();

        $form = $this->createFormBuilder($customer)
        ->add('name', TextType::class)
        ->add('cpfCnpj', TextType::class)
        ->add('phone', TextType::class)
        ->add('address', TextType::class);
        return $this->render('customerForm.html.twig');
    }
}