<?php
namespace BPCI\SumUp\Customer\Card;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\OAuth\AccessToken;
use Psr\Http\Message\ResponseInterface;


class CardClient implements CardClientInterface
{

    static function getScopes(): array {
        return [
            'payment_instruments'
        ];
    }

	/**
	 * Retieve a card from server and fill the $card Object with response.
	 *
	 * @param CardInterface $card
	 * @param CustomerInterface $customer
	 * @param ContextInterface $context
	 * @param AccessToken $accessToken
	 * @return CardInterface
	 */
	public static function get(
		CardInterface $card,
		CustomerInterface $customer,
		ContextInterface $context,
		AccessToken $accessToken
	): CardInterface {
		// TODO: Implement get() method.
	}

	/**
	 * Delete an card from server.
	 *
	 * @param CardInterface $card
	 * @param CustomerInterface $customer
	 * @param ContextInterface $context
	 * @param AccessToken $accessToken
	 * @return void
	 */
	public static function delete(
		CardInterface $card,
		CustomerInterface $customer,
		ContextInterface $context,
		AccessToken $accessToken
	): void {
		// TODO: Implement delete() method.
	}

	/**
	 * CheckoutClientInterface constructor.
	 * @param ContextInterface $context
	 */
	public function __construct(ContextInterface $context)
	{
		parent::__construct($context);
	}

	/**
	 * Return last response of client
	 * @return ResponseInterface
	 */
	function getLastResponse(): ResponseInterface
	{
		// TODO: Implement getLastResponse() method.
	}

	/**
	 * return the context used to created the client.
	 * @return ContextInterface
	 */
	function getContext(): ContextInterface
	{
		// TODO: Implement getContext() method.
	}

	/**
	 * Create a new card resource and fill the $card Object with response.
	 *
	 * @param CardInterface $card
	 * @param CustomerInterface $costumer
	 * @param ContextInterface $context
	 * @param AccessToken $accessToken
	 * @return CardInterface
	 */
	public static function create(
		CardInterface $card,
		CustomerInterface $costumer,
		ContextInterface $context,
		AccessToken $accessToken
	): CardInterface {
		// TODO: Implement create() method.
	}
}
