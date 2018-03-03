<?php

namespace BPCI\SumUp\Customer\PaymentInstrument;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\Traits\Client;
use BPCI\SumUp\Traits\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;


class PaymentInstrumentClient implements PaymentInstrumentClientInterface, ClientInterface
{
    use Client;

    protected $context;
    protected $options;
    protected $token;
    /**
     * @var CustomerInterface
     */
    protected $customer;
    /**
     * @var Response
     */
    protected $lastResponse;

    static function getScopes(): array
    {
        return [
            'payment_instruments'
        ];
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
        $uri = self::getEndPoint().'/'.$paymentInstrument->getToken();

        return $this->request('delete', $paymentInstrument, $uri);
	}

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
	 * Return last response of client
	 * @return ResponseInterface
	 */
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
        return $this->context;
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
     * @param ResponseInterface $response
     * @return SumUpClientInterface
     */
    function setLastResponse(ResponseInterface $response): SumUpClientInterface
    {
        $this->lastResponse = $response;

        return $this;
    }

    /**
     * @return array
     */
    function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string
     */
    function getEndPoint(): string
    {
        return 'customers/'.$this->customer->getCustomerId().'/payment-instruments';
    }

    /**
     * @param AccessToken $token
     * @return SumUpClientInterface
     */
    function setToken(AccessToken $token): SumUpClientInterface
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return AccessToken
     */
    function getToken():? AccessToken
    {
        return $this->token;
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

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
	}
}
