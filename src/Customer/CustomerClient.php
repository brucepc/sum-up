<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Customer\Card\CardInterface;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Exception\InvalidCustomerException;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\Utils\Hydrator;
use Psr\Http\Message\ResponseInterface;

class CustomerClient implements CustomerClientInterface
{
    const ENDPOINT = 'customers';
    protected $context;
    protected $lastResponse;

    /**
	 * CheckoutClientInterface constructor.
	 * @param ContextInterface $context
	 */
	public function __construct(ContextInterface $context)
	{
		$this->context = $context;
	}

    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public function createCard(CustomerInterface $customer, CardInterface $card, AccessToken $accessToken): ?CardInterface
    {
        //TODO Implement this method

    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public function getCards(CustomerInterface $custome, AccessToken $accessToken): array
    {
        //TODO Implement this method
    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public function deleteCard(CustomerInterface $customer, CardInterface $card, AccessToken $accessToken): void
    {
        //TODO Implement this method
    }

    /**
     * @inheritDoc
     * @throws BadRequestException
     * @throws InvalidCustomerException
     */
    public function create(CustomerInterface $customer, AccessToken $accessToken): ?CustomerInterface
    {
        $accessToken = AuthenticationHelper::getValidToken($this->context, $accessToken, self::getScopes());
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
            $wrapper = new Hydrator($response);
            $customer = $wrapper->hydrate($customer);
            return $customer;
        }

        return null;
    }

	private function request(string $action, CustomerInterface $customer, AccessToken $accessToken, array $scopes):? CustomerInterface
	{
		$accessToken = AuthenticationHelper::getValidToken(
			$this->context,
			$accessToken,
			$scopes??self::getScopes()
		);

		$client = SumUp::getClient();
		$options = AuthenticationHelper::getOAuthHeader($accessToken);
		$options['form_params'] = self::getCustomerBody($customer);

		$successCode=200;
		$uri = self::ENDPOINT . '/' . $customer->getCustomerId();
		switch (true){
			case $action==='create': {
				$action='post';
				$successCode=201;
				$uri = self::ENDPOINT;
				break;
			}
			case $action==='complete': {
				$action='put';
				break;
			}
			default:{
				$action='get';
				break;
			}
		}

		/** @var ResponseInterface $response */
		$response = $client->{$action}($uri, $options);
		$this->lastResponse = $response;
		if($successCode===$response->getStatusCode()){
			$wrapper = new Hydrator($response);
			return $wrapper->hydrate($customer);
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

    public function setContext(ContextInterface $context): CustomerClientInterface
	{
		$this->context = $context;
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

	function getLastResponse(): ResponseInterface
	{
		return $this->lastResponse;
	}


	/**
	 * return the context used to created the client.
	 * @return ContextInterface
	 */
	function getContext(): ContextInterface
	{
		// TODO: Implement getContext() method.
	}
}
