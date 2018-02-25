<?php

namespace BPCI\SumUp\OAuth;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUp;
use GuzzleHttp\Client;

class AuthenticationHelper
{
	const OAUTH_AUTHORIZATION = 'authorize';
	const OAUTH_TOKEN = 'token';

	/**
	 * Generate an url to merchant authorization.
	 *
	 * @param ContextInterface $context
	 * @param boolean $minimal
	 * @return string
	 */
	public static function getAuthorizationURL(ContextInterface $context, $minimal = true)
	{
		$queryString = [
			'client_id' => $context->getClientId(),
			'client_secret' => $context->getClientSecret(),
			'redirect_uri' => $context->getRedirectUri(),
			'response_type' => 'code',
		];

		if (!$minimal) {
			$queryString = array_merge($queryString, [
				'scope' => $context->getScope(),
				'state' => $context->getState(),
			]);
		}

		return SumUp::ENTRYPOINT . self::OAUTH_AUTHORIZATION . '?' . http_build_query($queryString);
	}

	/**
	 * Request an acess token from sumup services.
	 *
	 * @param Context $context
	 * @param Array|null $scopes
	 * @return AccessToken
	 * @throws BadRequestException
	 */
	public static function getAccessToken(ContextInterface $context, array $scopes = null): AccessToken
	{
		$formParams = [
			'grant_type' => 'client_credentials',
			'client_id' => $context->getClientId(),
			'client_secret' => $context->getClientSecret(),
		];

		if ($scopes !== null) {
			$formParams['scope'] = implode(',', $scopes);
		}

		$client = new Client(['base_uri' => SumUp::ENTRYPOINT]);

		$response = $client->request(
			'POST',
			self::OAUTH_TOKEN,
			[
				'form_params' => $formParams,
			]);

		$code = $response->getStatusCode();
		if ($code !== 200) {
			$message = " Request code: $code \n Message: " . $response->getReasonPhrase();
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

	/**
	 * If available check token or generate a new token
	 *
	 * @param ContextInterface $context
	 * @param AccessToken $token
	 * @param array $scopes
	 *
	 * @return AccessToken
	 */
	public static function getValidToken(ContextInterface $context, AccessToken $token = null, array $scopes = null): AccessToken
	{
		if ($token === null || !$token->isValid()) {
			$token = AuthenticationHelper::getAccessToken($context, $scopes);
		}

		return $token;
	}

	public static function getOAuthHeader(AccessToken $token): array
	{
		return [
			'headers' => [
				'Authorization' => $token->getType() . ' ' . $token->getToken(),
			],
		];
	}
}
