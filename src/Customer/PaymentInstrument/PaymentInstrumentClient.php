<?php

namespace BPCI\SumUp\Customer\PaymentInstrument;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\Traits\Client;
use BPCI\SumUp\Traits\ClientInterface;
use Psr\Http\Message\ResponseInterface;


class PaymentInstrumentClient implements PaymentInstrumentClientInterface, ClientInterface
{
    use Client;

    protected $context;
    protected $options = [];
    protected $token;
    /**
     * @var CustomerInterface
     */
    protected $customer;
    /**
     * @var ResponseInterface
     */
    protected $lastResponse;

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

    static function getScopes(): array
    {
        return [
            'payment_instruments'
        ];
    }

    /**
     * @param PaymentInstrumentInterface $object
     * @param string|null $type
     * @return mixed
     */
    static function getBody($object, string $type = null)
    {
        return null;
    }

	/**
     * Retrieve a paymentInstrument from server and fill the $paymentInstrument Object with response.
	 *
	 */
    public function get(): array
    {
        $response = [];
        if ($this->request('get')) {
            $response = \GuzzleHttp\json_decode(
                $this->lastResponse->getBody(),
                true
            );
        };

        return $response;
	}

	/**
     * Delete an paymentInstrument from server.
	 *
     * @param PaymentInstrumentInterface $paymentInstrument
     * @return bool
	 */
    public function disable(PaymentInstrumentInterface $paymentInstrument):?bool
    {
        $uri = $this->getEndPoint().'/'.$paymentInstrument->getToken();

        return $this->request('delete', $paymentInstrument, $uri);
	}

    /**
     * @return string
     */
    public function getEndPoint(): string
    {
        return 'customers/'.$this->customer->getCustomerId().'/payment-instruments';
    }

	/**
	 * Return last response of client
	 * @return ResponseInterface
	 */
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
     * return the context used to created the client.
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->context;
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
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface $customer
     * @return PaymentInstrumentClientInterface
     */
    public function setCustomer(CustomerInterface $customer): PaymentInstrumentClientInterface
    {
        $this->customer = $customer;

        return $this;
    }
}
