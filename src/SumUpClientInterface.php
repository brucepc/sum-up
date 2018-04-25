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
    public function __construct(ContextInterface $context, ?array $options = []);

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
     * @deprecated
     */
    static function getBody($object, string $type = null);

    /**
     * Return last response of client
     * @return ResponseInterface
     */
    public function getLastResponse(): ResponseInterface;

    /**
     * @param ResponseInterface $response
     * @return SumUpClientInterface
     */
    public function setLastResponse(ResponseInterface $response): SumUpClientInterface;

    /**
     * return the context used to created the client.
     * @return ContextInterface
     */
    public function getContext(): ContextInterface;

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @return string
     */
    public function getEndPoint(): string;

    /**
     * @param AccessToken $token
     * @return SumUpClientInterface
     */
    public function setToken(AccessToken $token): SumUpClientInterface;

    /**
     * @return AccessToken
     */
    public function getToken(): ? AccessToken;
}
