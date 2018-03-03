<?php
namespace BPCI\SumUp;

use BPCI\SumUp\OAuth\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface SumUpClientInterface
 * @package BPCI\SumUp
 */
interface SumUpClientInterface
{
    /**
     * CheckoutClientInterface constructor.
     * @param ContextInterface $context
     * @param array $options
     */
    function __construct(ContextInterface $context, ?array $options = []);

    /**
     * Shows in an array all scopes required by the client
     *
     * @return array
     */
    static function getScopes(): array;

    /**
     * @param $object
     * @param string|null $type
     * @return mixed
     */
    static function getBody($object, string $type = null);

    /**
     * Return last response of client
     * @return ResponseInterface
     */
    function getLastResponse(): ResponseInterface;

    /**
     * @param ResponseInterface $response
     * @return SumUpClientInterface
     */
    function setLastResponse(ResponseInterface $response): SumUpClientInterface;

    /**
     * return the context used to created the client.
     * @return ContextInterface
     */
    function getContext(): ContextInterface;

    /**
     * @return array
     */
    function getOptions(): array;

    /**
     * @return string
     */
    function getEndPoint(): string;

    /**
     * @param AccessToken $token
     * @return SumUpClientInterface
     */
    function setToken(AccessToken $token): SumUpClientInterface;

    /**
     * @return AccessToken
     */
    function getToken():? AccessToken;
}
