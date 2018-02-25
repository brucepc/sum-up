<?php
namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\SumUp;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CheckoutClient
 * @package BPCI\SumUp\Checkout
 */
class CheckoutClient implements CheckoutClientInterface
{
	const ENDPOINT = 'checkouts';
	protected $context;
	protected $lastResponse;

	function __construct(ContextInterface $context)
	{
		$this->context = $context;
	}

	/**
	 * @inheritDoc
	 * @throws BadResponseException
	 * @throws ConnectException
	 */
	public function create(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface
	{
		return $this->request('post', $checkout, $accessToken, self::getScopes())? $checkout: null;
	}

	/**
	 * @inheritDoc
	 * @throws BadResponseException
	 * @throws ConnectException
	 */
	public function get(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface
	{
		return $this->request('get', $checkout, $accessToken, self::getScopes())? $checkout: null;
	}


	/**
	 * @inheritDoc
	 * @throws BadResponseException
	 * @throws ConnectException
	 */
	public function complete(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface
	{
		return $this->request('put', $checkout, $accessToken, self::getScopes())? $checkout: null;
	}

	/**
	 * @param string $action
	 * @param CheckoutInterface $checkout
	 * @param AccessToken $accessToken
	 * @param array $scopes
	 * @return bool|null
	 * @throws BadResponseException
	 * @throws ConnectException
	 */
	protected function request(string $action, CheckoutInterface $checkout, AccessToken $accessToken, array $scopes):? bool
	{
		$accessToken = AuthenticationHelper::getValidToken($this->context, $accessToken, $scopes??self::getScopes());

		$client = SumUp::getClient();
		$options = AuthenticationHelper::getOAuthHeader($accessToken);
		$options['form_params'] = self::getCheckoutBody($checkout);

		$uri = self::ENDPOINT . '/' . $checkout->getId();
		if($action=='post'){
			$uri = self::ENDPOINT;
		}

		/** @var Response $response */
		$response = $client->{$action}($uri, $options);
		$this->lastResponse = $response;
		if($response->getStatusCode() < 300 && $response->getStatusCode() >= 200){
			$hydrator = SumUp::getHydrator();
			$data = \GuzzleHttp\json_decode($response->getBody(), true);
			$hydrator->hydrate($data, $checkout);
			return true;
		}

		return false;
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

	public static function getCompleteCheckoutBody(CheckoutInterface $checkout): array
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
				'cpf_cnpj' => $customer->getCpfCnpj(),
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
	public static function getScopes(): array
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

}
