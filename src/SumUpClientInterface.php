<?php
namespace BPCI\SumUp;

use Psr\Http\Message\ResponseInterface;

interface SumUpClientInterface
{
	/**
	 * CheckoutClientInterface constructor.
	 * @param ContextInterface $context
	 */
	function __construct(ContextInterface $context);

    /**
     * Shows in an array all scopes required by the client
     *
     * @return array
     */
    static function getScopes(): array;

	/**
	 * Return last response of client
	 * @return ResponseInterface
	 */
	function getLastResponse(): ResponseInterface;

	/**
	 * return the context used to created the client.
	 * @return ContextInterface
	 */
	function getContext(): ContextInterface;
}
