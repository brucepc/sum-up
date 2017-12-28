<?php
namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\SumUpClientInterface;

class CheckoutClient implements CheckoutClientInterface
{
    const ENDPOINT = 'checkouts';
    /**
     * @inheritDoc
     * @throws InvalidCheckoutException
     * @throws BadRequestException
     */
    public static function create(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface
    {
        $accessToken = AuthenticationHelper::getValidToken($accessToken);

        if (!$checkout->isValid()) {
            throw new InvalidCheckoutException('Ops! Something is wrong with checkout.');
        }

        $checkoutClient = SumUp::getClient();
        $headers = AuthenticationHelper::getHeader($accessToken);
        $body = self::getCheckoutBody($checkout);
        $response = $checkoutClient->post(self::ENDPOINT, $headers, $body);

        if ($response->getStatusCode() === 409) {
            $error = json_decode($response->getBody()->getContents(), true);
            throw new BadRequestException("{$error['error_code']}: {$error['message']}");
        }

        if ($response->getStatusCode() === 200) {
            $wrapper = new ResponseWrapper($response);
            $wrapper->hydrate($checkout);
            return $checkout;
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public static function get(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface
    {
        //TODO fill this to retrieve an checkout from API.
    }

    /**
     * @inheritDoc
     */
    public static function complete(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface
    {
        $accessToken = AuthenticationHelper::getValidToken($accessToken);

        if (!$checkout->isValid()) {
            throw new InvalidCheckoutException('Ops! Something is wrong with checkout.');
        }

        /* @var GuzzleHttp\Client $client */
        $client = SumUp::getClient();
        $headers = AuthenticationHelper::getOAuthHeader($accessToken);
        $body = self::getCompleteCheckoutBody($checkout);

        if($checkout->getCurrency==='BRL') {
            $body['installments'] = $checkout->getInstallments();
        }

        $response = $client->put(self::ENDPOINT . '/' . $checkout->getId(), $headers, $body);

        if ($response->getStatusCode() === 409) {
            $error = json_decode($response->getBody()->getContents(), true);
            throw new BadRequestException("{$error['error_code']}: {$error['message']}");
        }

        if ($response->getStatusCode() === 200) {
            $wrapper = new ResponseWrapper($response);
            $wrapper->hydrate($checkout);

            return $checkout;
        }

        return null;
    }

    /**
     * Generate a body to create a new checkout
     *
     * @param CheckoutInterface $checkout
     * @return array
     */
    public static function getCheckoutBody(CheckoutInterface $checkout): array
    {
        return [
            "checkout_reference" => $checkout->getCheckoutReference(),
            "amount" => $checkout->getAmout(),
            "currency" => $checkout->getCurrency(),
            "pay_to_email" => $checkout->getPayToEmail(),
            "pay_from_email" => $checkout->getPayFromEmail(),
            "fee_amount" => $checkout->getFeeAmount(),
            "description" => $checkout->getDescription(),
            "return_url" => $checkout->getRedirectUrl(),
        ];
    }

    public static function getCompleteCheckoutBody(CheckoutInterface $checkout): array 
    {
        $defaultBody = self::getCheckoutBody($checkout);
        switch ($checkout->getType()) {
            case 'card':
                $completeBody = self::getCardBody($checkout);
                break;
            
            case 'boleto':
                $completeBody = [];
                break;
            
            default:
                throw new InvalidCheckoutException('Ops! The checkout type requested was not implemented yet.');
                break;
        }

        return array_merge($defaultBody, $completeBody);
    }

    private static function getCardBody(CheckoutInterface $checkout): Array
    {
        return [
            'payment_type' => $checkout->getType(),
            'token' => $checkout->getCard()->getToken(),
            'customer_id' => $checkout->getCustomer()->getId()
        ];
    }

    private static function getBoletoBody(CheckoutInterface $checkout)
    {
        $customer = $checkout->getCustomer();
        return [
            'payment_type' => $checkout->getType(),
            'description' => $checkout->getDescription(),
            'boleto_details' => [
                'cpf_cnpj' => $customer->getCpfCnpj(),
                'payer_name' => $customer->getName(),
                'payer_address' => $customer->getAddress(),
                'payer_city' => $customer->getCity(),
                'payer_state_code' => $customer->getStateCode(),
                'payer_post_code' => $customer->getPostCode()
            ],
        ];
    }
    
    /**
     * @inheritDoc
     */
    public static function getScopes(): array
    {
        return [
            'payments',
            'boleto'
        ];
    }
}
