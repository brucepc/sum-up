<?php

namespace BPCI\SumUp;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class SumUp
{
	const VERSION = 'v0.1';
	const ENTRYPOINT = 'https://api.sumup.com/';
    const CLIENT_DEFAULT_OPTIONS = [
        'base_uri' => self::ENTRYPOINT.self::VERSION.'/',
        'timeout' => 5,
    ];

	/**
     * @param array $options
     * @return ClientInterface
	 */
    static function getClient(array $options = []): ClientInterface
	{
        $options = array_merge_recursive(
            self::CLIENT_DEFAULT_OPTIONS,
            $options
		);

        return new Client($options);
	}

	static function getEntrypoint(): string
    {
        return self::CLIENT_DEFAULT_OPTIONS['base_uri'];
	}
}

