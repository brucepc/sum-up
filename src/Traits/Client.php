<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 26/02/18
 * Time: 13:52
 */

namespace BPCI\SumUp\Traits;

use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\SumUpClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

/**
 * Trait Client
 * @package BPCI\SumUp\Traits
 */
trait Client
{
    /**
     * @param string $action
     * @param mixed $object
     * @param string $endpoint
     * @return bool|null
     * @throws BadResponseException
     * @throws ConnectException
     */
    public function request(string $action, $object = null, string $endpoint = null):? bool
    {
        /** @var SumUpClientInterface $this */

        if (!$this instanceof SumUpClientInterface) {
            throw new \RuntimeException('This object doesn\'t implements the SumUpClientInterface.');
        }

        $scopes = $this::getScopes();

        $accessToken = AuthenticationHelper::getValidToken($this->getContext(), $this->getToken(), $scopes);

        $client = SumUp::getClient($this->getOptions());
        $options = AuthenticationHelper::getOAuthHeader($accessToken);
        if ($object !== null) {
            $options['form_params'] = $this::getBody($object, $action);
        }

        $uri = $endpoint??$this->getEndPoint();

        try {
            /** @var \GuzzleHttp\Psr7\Response $response */
            $response = $client->{$action}($uri, $options);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        $this->setLastResponse($response);
        $statusCode = $response->getStatusCode();
        if ($statusCode < 300 && $statusCode > 199) {
            $data = \GuzzleHttp\json_decode($response->getBody(), true);
            if ($object instanceof PropertyHandlerInterface) {
                $object->fillProperties($data);
            }

            return true;
        }

        return false;
    }
}
