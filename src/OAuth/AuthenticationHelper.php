<?php

namespace BPCI\SumUp\OAuth;

use BPCI\SumUp\SDK\ContextInterface;
use BPCI\SumUp\SDK\OAuth\AccessToken;
use BPCI\SumUp\SDK\Exception\BadRequestException;
use GuzzleHttp\Client;

class AuthenticationHelper{
    const OAUTH_AUTHORIZATION = '/authorize';
    const OAUTH_TOKEN = '/token';

    /**
     * Generate an url to merchant authorization.
     *
     * @param Context $context
     * @param boolean $minimal
     * @return string
     */
    static function getAuthorizationURL(ContextInterface $context, $minimal = true){
        $queryString = [
            'client_id' => $context->getClientId(),
            'client_secret' => $context->getClientSecret(),
            'redirect_uri' => $context->getRedirectUri(),
            'response_type' => 'code'
        ];

        if(!$minimal){
            $queryString = array_merge($queryString, [
                'scope' => $context->getScope(),
                'state' => $context->getState(),
            ]);
        }

        return SumUp::ENTRYPOINT.self::OAUTH_AUTHORIZATION.'?'.http_build_query($queryString);
    }

    /**
     * Request an acess token from sumup services.
     *
     * @param Context $context
     * @param Array|null $scopes
     * @return AccessToken
     * @throws BadRequestException
     */
    static function getAccessToken(ContextInterface $context, Array $scopes = null): AccessToken{
        $formParams = [
            'grant_type' => 'client_credentials',
            'client_id' => $context->getClientId(),
            'client_secret' => $context->getClientSecret()
        ];

        if($scopes !== null){
            $formParams['scope'] = array_join(',', $scopes);
        }

        $client = new Client(['base_uri' => SumUp::ENTRYPOINT]);

        $response = $client->request(
            'POST', 
            self::OAUTH_TOKEN,
            [
            'form_params' => $formParams
            ]);

        $code = $response->getStatusCode();
        if($code !== 200)
        {
            $message = " Request code: $code \n Message: ". $response->getReasonPhrase();
            throw new BadRequestException($message);
        }

        $body = $response->json();
        $token_params = [
            $body['access_token'], 
            $body['token_type'],
            $body['expires_in'],
        ];

        if(isset($body['scope'])){
            $token_params[] = $body['scope'];
        }    

        return new AccessToken(...$token_params);
    }

    /**
     * If available check token or generate a new token
     * 
     * @param Context $context
     * @param AccessToken $token
     * 
     * @return AccessToken
     */
    static function getValidToken(ContextInterface $context, AccessToken $token = null): AccessToken
    {
        if($accessToken === null){
            $accessToken = AuthenticationHelper::getAcessToken($context, self::getScopes());
        }else{
            if(!$accessToken->isValid()){
                $accessToken = AuthenticationHelper::getAcessToken($context, $accessToken->getScope());                
            }
        }
        return $accessToken;
    }

    static function getOAuthHeader(AccessToken $token): string
    {
        return [
            'authorization' => $token->getType(). ' ' . $token->getToken()
        ];
    }
}