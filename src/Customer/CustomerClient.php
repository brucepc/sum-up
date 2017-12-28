<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\Exception\InvalidCustomerException;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\Utils\ResponseWrapper;

class CustomerClient implements CustomerClientInterface
{
    const ENDPOINT = 'customers';
    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public static function createCard(CardInterface $card, CustomerInterface $costumer, ContextInterface $context, AccessToken $accessToken)
    {
        //TODO Implement this method
    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public static function getCards(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken)
    {
        //TODO Implement this method
    }

    /** 
     * @inheritDoc 
     * @throws BadRequestException
     */
    public static function deleteCard(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken)
    {
        //TODO Implement this method
    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     * @throws InvalidCustomerException
     */
    public static function create(CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): Array
    {
        $accessToken = AuthenticationHelper::getValidToken($accessToken, self::getScopes());
        self::validateCustomer($customer);
        $client = SumUp::getClient();
        $headers = OAuthenticationHelper::getOAuthHeader($accessToken);
        $body = self::getCustomerBody($customer);
        $response = $client->post(self::ENDPOINT, $headers, $body);

        if($response->getStatusCode()===201)
        {
            $wrapper = new ResponseWrapper($response);
            $wrapper->hydrate($customer);
            return $costumer;
        }
    }

    /**
     * Validate an customer
     *
     * @param CustomerInterface $customer
     * @return void
     * @throws InvalidCustomerException
     */
    private static function validateCustomer(CustomerInterface $customer): void
    {
        if(!$customer->isValid())
        {
            throw new InvalidCustomerException('Ops! Something is wrong with this CustomerInterface Instance');
        }
    }

    static function getCustomerBody(CustomerInterface $customer): Array
    {
        return [
            'customer_id' => $customer->getCustomerId(),
            'personal_details' => [
                'name' => $customer->getName(),
                'phone' => $customer->getPhone(),
                'address' => [
                    'line1' => $customer->getAddress()->getLine1(),
                    'line2' => $customer->getAddress()->getLine2(),
                    'country' => $customer->getAddress()->getCountry(),
                    'postal_code' => $customer->getAddress()->getPostalCode(),
                    'city' => $customer->getAddress()->getCity(),
                    'state' => $customer->getAddress()->getState(),
                ]
            ]
        ];
    }

    /** 
     * @inheritDoc
     */
    static function getScopes(): Array{
        return [
            'payment_instruments'
        ];
    }

}