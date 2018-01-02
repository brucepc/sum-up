<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Customer\Card\CardInterface;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Exception\InvalidCustomerException;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\Utils\ResponseWrapper;

class CustomerClient implements CustomerClientInterface
{
    const ENDPOINT = 'customers';
    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public static function createCard(CustomerInterface $customer, CardInterface $card, ContextInterface $context, AccessToken $accessToken): ?CardInterface
    {
        //TODO Implement this method

    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public static function getCards(CustomerInterface $custome, ContextInterface $context, AccessToken $accessToken): array
    {
        //TODO Implement this method
    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public static function deleteCard(CustomerInterface $customer, CardInterface $card, ContextInterface $context, AccessToken $accessToken): void
    {
        //TODO Implement this method
    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     * @throws InvalidCustomerException
     */
    public static function create(CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): ?CustomerInterface
    {
        $accessToken = AuthenticationHelper::getValidToken($accessToken, $context, self::getScopes());
        self::validateCustomer($customer);
        $client = SumUp::getClient();
        $headers = AuthenticationHelper::getOAuthHeader($accessToken);
        $body = self::getCustomerBody($customer);
        try {
            $response = $client->post(self::ENDPOINT, [
                'headers' => $headers
            ], $body);
            $successul = $response->getStatusCode() === 201;
        } catch(\GuzzleHttp\Exception\RequestException $e){
            throw new BadRequestException(
                $e->getMessage(),
                $e->getRequest(),
                $e->getResponse()
            );
        }

        if ($successul) {
            $wrapper = new ResponseWrapper($response);
            $wrapper->hydrate($customer);
            return $costumer;
        }

        return null;
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
        if (!$customer->isValid()) {
            throw new InvalidCustomerException('Ops! Something is wrong with this CustomerInterface Instance');
        }
    }

    public static function getCustomerBody(CustomerInterface $customer): array
    {
        $customerBody = [
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
                ],
            ],
        ];

        if ($customer->getCustomerId() !== null) {
            $customerBody['customer_id'] = $customer->getCustomerId();
        }

        return $customerBody;
    }

    /**
     * @inheritDoc
     */
    public static function getScopes(): array
    {
        return [
            'payment_instruments',
        ];
    }

}
