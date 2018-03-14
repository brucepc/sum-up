<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Customer\PaymentInstrument\PaymentInstrumentClient;
use BPCI\SumUp\Customer\PaymentInstrument\PaymentInstrumentInterface;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Exception\InvalidCustomerException;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\Traits\Client;
use BPCI\SumUp\Traits\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class CustomerClient implements CustomerClientInterface, ClientInterface
{
    use Client;

    const ENDPOINT = 'customers';
    protected $context;
    protected $token;
    protected $lastResponse;
    protected $options = [];

    /**
	 * CheckoutClientInterface constructor.
	 * @param ContextInterface $context
     * @param array $options
     */
    public function __construct(ContextInterface $context, ?array $options = [])
	{
		$this->context = $context;
        $this->options = $options;
	}

    /**
     * @param $customer
     * @param string|null $type
     * @return array
     */
    static function getBody($customer, string $type = null)
    {
        if (!$customer instanceof CustomerInterface) {
            throw new InvalidCustomerException('Invalid customer or $customer does not implement CustomerInterface!');
        }

        $body = [
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
                ],
            ],
        ];

        return $body;
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

    /**
     * @inheritDoc
     * @throws BadRequestException
     */
    public function create(CustomerInterface $customer): ?CustomerInterface
    {
        return $this->request('post', $customer) ? $customer : null;
    }

    public function getLastResponse(): ResponseInterface
	{
		return $this->lastResponse;
	}

    /**
     * @param ResponseInterface $response
     * @return SumUpClientInterface
     */
    public function setLastResponse(ResponseInterface $response): SumUpClientInterface
    {
        $this->lastResponse = $response;

        return $this;
    }

    /**
     * Delete a customer card.
     *
     * @param CustomerInterface $customer
     * @param PaymentInstrumentInterface $paymentInstrument
     * @return bool
     */
    public function disablePaymentInstrument(
        CustomerInterface $customer,
        PaymentInstrumentInterface $paymentInstrument
    ): bool
    {
        $instrumentClient = new PaymentInstrumentClient($this->getContext(), $this->getOptions());
        $instrumentClient->setCustomer($customer);
        $instrumentClient->setToken($this->getToken());
        $response = $instrumentClient->disable($paymentInstrument);
        $this->setLastResponse($instrumentClient->getLastResponse());

        return $response??false;
    }

    /**
     * return the context used to created the client.
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->context;
    }

    public function setContext(ContextInterface $context): CustomerClientInterface
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options??[];
    }

    /**
     * @return AccessToken
     */
    public function getToken():? AccessToken
    {
        return $this->token;
    }

    /**
     * @param AccessToken $token
     * @return SumUpClientInterface
     */
    public function setToken(AccessToken $token): SumUpClientInterface
    {
        $this->token = $token;

        return $this;
    }

    /**
     * This must return an Array of PaymentInstrumentInterface
     *
     * @param CustomerInterface $customer
     * @return array
     */
    public function getPaymentInstruments(CustomerInterface $customer): array
    {
        $instrumentClient = new PaymentInstrumentClient($this->getContext(), $this->getOptions());
        $instrumentClient->setCustomer($customer);
        $instrumentClient->setToken($this->getToken());
        $response = $instrumentClient->get();
        $this->setLastResponse($instrumentClient->getLastResponse());

        return $response??[];
    }

    /**
     * @return string
     */
    public function getEndPoint(): string
    {
        return 'customers';
    }
}
