<?php
namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Exception\InvalidCheckoutException;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\Traits\Client;
use BPCI\SumUp\Traits\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CheckoutClient
 * @package BPCI\SumUp\Checkout
 */
class CheckoutClient implements CheckoutClientInterface, ClientInterface
{
    use Client {
        request as protected traitRequest;
    }

	protected $context;
	protected $lastResponse;
    protected $options = [];
    protected $currentToken;

    function __construct(ContextInterface $context, ?array $options = [])
	{
		$this->context = $context;
        $this->options = $options;
	}

	/**
	 * @inheritDoc
	 * @throws BadResponseException
	 * @throws ConnectException
	 */
    function create(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface
	{
        return $this->request('post', $checkout) ? $checkout : null;
	}

	/**
	 * @inheritDoc
	 * @throws BadResponseException
	 * @throws ConnectException
	 */
    function complete(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface
	{
        return $this->request('put', $checkout) ? $checkout : null;
	}

	/**
	 * @param string $action
	 * @param CheckoutInterface $checkout
     * @param string|null $endpoint
	 * @return bool|null
	 */
    function request(string $action, $checkout, string $endpoint = null):? bool
	{
        if (!$checkout->isValid()) {
            throw new InvalidCheckoutException($checkout);
		}

        return $this->traitRequest($action, $checkout);
	}

	/**
	 * Generate a body to create a new checkout
	 *
	 * @param CheckoutInterface $checkout
	 * @return array
	 */
    protected static function getCheckoutBody(CheckoutInterface $checkout): array
	{
		return [
			"checkout_reference" => $checkout->getReference(),
			"amount" => $checkout->getAmount(),
			"currency" => $checkout->getCurrency(),
			"fee_amount" => $checkout->getFeeAmount(),
			"pay_to_email" => $checkout->getPayToEmail(),
			"pay_from_email" => $checkout->getPayFromEmail(),
			"description" => $checkout->getDescription(),
			"return_url" => $checkout->getRedirectUrl(),
		];
	}

    /**
     * @param CheckoutInterface $checkout
     * @param string|null $type
     * @return array
     */
    static function getBody($checkout, string $type = null): array
	{
		$defaultBody = self::getCheckoutBody($checkout);
		switch ($checkout->getType()) {
			case 'card':
				$completeBody = self::getCardBody($checkout);
				break;

			case 'boleto':
				$completeBody = self::getBoletoBody($checkout);
				break;

			default:
				$completeBody = [];
		}

		return array_merge($defaultBody, $completeBody);
	}

	private static function getCardBody(CheckoutInterface $checkout): array
	{
		return [
			'payment_type' => $checkout->getType(),
			'token' => $checkout->getCard()->getToken(),
			'customer_id' => $checkout->getCustomer()->getCustomerId()
		];
	}

	private static function getBoletoBody(CheckoutInterface $checkout): array
	{
		$customer = $checkout->getCustomer();
		return [
			'payment_type' => $checkout->getType(),
			'description' => $checkout->getDescription(),
			'boleto_details' => [
//				'cpf_cnpj' => $customer->getCpfCnpj(),
				'payer_name' => $customer->getName(),
				'payer_address' => $customer->getAddress(),
				'payer_city' => $customer->getAddress()->getCity(),
				'payer_state_code' => $customer->getAddress()->getState(),
				'payer_post_code' => $customer->getAddress()->getPostalCode()
			],
		];
	}

	/**
	 * @inheritDoc
	 */
    static function getScopes(): array
	{
		return [
			'payments',
			'boleto'
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
		return $this->context;
	}

    function getOptions(): array
    {
        return $this->options;
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
     * @return string
     */
    function getEndPoint(): string
    {
        return 'checkouts';
    }

    /**
     * @param AccessToken $token
     * @return SumUpClientInterface
     */
    function setToken(AccessToken $token): SumUpClientInterface
    {
        $this->currentToken = $token;

        return $this;
    }

    /**
     * @return AccessToken
     */
    function getToken():? AccessToken
    {
        return $this->currentToken;
    }

    /**
     * @param CheckoutInterface $checkout
     * @return string
     */
    static function getCompleteUrl(CheckoutInterface $checkout): string
    {
        if ($checkout->getId()) {
            return SumUp::getEntrypoint().$checkout->getId();
        }

        return '';
    }
}
