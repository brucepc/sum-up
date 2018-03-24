<?php

namespace BPCI\SumUp\OAuth;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\SumUp;

class AuthenticationHelper
{
    const OAUTH_AUTHORIZATION = 'authorize';
    const OAUTH_TOKEN = 'token';

    /**
     * Generate an url to merchant authorization.
     *
     * @param ContextInterface $context
     * @return string
     */
    public static function getAuthorizationURL(ContextInterface $context)
    {
        $queryString = [
            'client_id' => $context->getClientId(),
            'client_secret' => $context->getClientSecret(),
            'redirect_uri' => $context->getRedirectUri(),
            'response_type' => 'code',
        ];

        return SumUp::ENTRYPOINT.self::OAUTH_AUTHORIZATION.'?'.http_build_query($queryString);
    }

    /**
     * If available check token or generate a new token
     *
     * @param ContextInterface $context
     * @param AccessToken $token
     * @param array $scopes
     * @param array $options
     *
     * @return \BPCI\SumUp\OAuth\AccessToken
     */
    public static function getValidToken(
        ContextInterface $context,
        AccessToken $token = null,
        array $scopes = null,
        array $options = []
    ): AccessToken {
        if ($token === null || !$token->isValid()) {
            $token = AuthenticationHelper::getAccessToken($context, $scopes, $options);
        }

        return $token;
    }

    /**
     * Request an acess token from sumup services.
     *
     * @param ContextInterface $context
     * @param array|null $scopes
     * @param array $options
     * @return \BPCI\SumUp\OAuth\AccessToken
     */
    public static function getAccessToken(
        ContextInterface $context,
        array $scopes = null,
        array $options = []
    ): AccessToken {
        $formParams = [
            'grant_type' => 'client_credentials',
            'client_id' => $context->getClientId(),
            'client_secret' => $context->getClientSecret(),
        ];

        if ($scopes !== null) {
            $formParams['scope'] = implode(',', $scopes);
        }

        $client = SumUp::getClient($options);

        $response = $client->request(
            'POST',
            '/'.self::OAUTH_TOKEN,
            [
                'form_params' => $formParams,
            ]
        );

        $code = $response->getStatusCode();
        if ($code !== 200) {
            $message = " Request code: $code \n Message: ".$response->getReasonPhrase();
            throw new BadRequestException($message);
        }

        $body = json_decode($response->getBody()->getContents(), true);
        $token_params = [
            $body['access_token'],
            $body['token_type'],
            $body['expires_in'],
        ];

        if (isset($body['scope'])) {
            $token_params[] = $body['scope'];
        }

        return new AccessToken(...$token_params);
    }

    public static function getOAuthHeader(AccessToken $token): array
    {
        return [
            'headers' => [
                'Authorization' => $token->getType().' '.$token->getToken(),
            ],
        ];
    }
}
