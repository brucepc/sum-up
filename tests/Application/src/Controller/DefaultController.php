<?php

namespace BPCI\SumUp\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use BPCI\SumUp\Context;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\Customer\CustomerClient;
use BPCI\SumUp\Tests\Entity\Customer;
use BPCI\SumUp\Tests\Entity\Checkout;
use BPCI\SumUp\Tests\Form\CustomerType;
use BPCI\SumUp\Tests\Form\CheckoutType;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Checkout\CheckoutClient;

class DefaultController extends AbstractController
{
    private $context;

    public function __construct()
    {
        $this->context = Context::loadContextFromFile(\realpath(__DIR__.'/../../var/sumup.json'));
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        $oauthURI = AuthenticationHelper::getAuthorizationURL($this->context);
        return $this->render('index.html.twig', [
            'authorization_url' => $oauthURI
        ]);
    }

    /**
     * @Route("/token", name="sumup_token")
     */
    public function token(): Response{
        $tokenResponse = AuthenticationHelper::getAccessToken($this->context);
        return $this->render('token.html.twig', [
            'accessToken' => $tokenResponse
        ]);
    }

    /**
     * @Route("/customer", name="sumup_customer")
     */
    public function createCustomer(Request $request): Response {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->add('save', SubmitType::class,[
            'label' => 'Create Customer'
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $customer = $form->getData();
            try{
                $token = AuthenticationHelper::getAccessToken($this->context);
                $customer = CustomerClient::create($customer, $this->context, $token);
            } catch(BadRequestException $e) {
                $response = $e->getResponse();
                return new Response($response->getBody());
            }
        }

        return $this->render('customerForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/checkout", name="sumup_checkout")
     *
     * @param Request $request
     * @return Response
     */
    function checkout(Request $request): Response{
        $form = $this->createForm(CheckoutType::class);
        $form->add('save', SubmitType::class, [
            'label' => 'Create Checkout'
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $checkoutData = $form->getData();
            $client = new CheckoutClient($this->context);
            try{
                $token = AuthenticationHelper::getAccessToken($this->context);
                $checkoutData = $client->create($checkoutData, $token);
            }catch(\Exception $e){
                return new Response($e->getMessage());
            }
        }

        return $this->render('checkoutForm.html.twig', [
        	'checkout' => $checkoutData??null,
            'form' => $form->createView()
        ]);
    }

	/**
	 * @Route("/checkout/all", name="sumup_checkout_all")
	 * @param Request $request
	 * @return Response
	 */
    function getAllCheckout(Request $request): Response{
    	$all_checkouts = CheckoutClient::getAll($this->context);
    	return $this->render('list_checkouts.html.twig', [
    		'checkouts' => $all_checkouts
		]);
	}
}
