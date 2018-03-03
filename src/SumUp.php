<?php

namespace BPCI\SumUp;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class SumUp
{
	const VERSION = 'v0.1';
	const ENTRYPOINT = 'https://api.sumup.com/';

	/**
     * @param array $options
     * @return ClientInterface
	 */
    static function getClient(array $options = []): ClientInterface
	{
        $options = array_merge_recursive(
			[
				'base_uri' => self::getEntrypoint(),
				'timeout' => 2
            ],
            $options
		);

        return new Client($options);
	}

	static function getEntrypoint(): string
	{
		return self::ENTRYPOINT.self::VERSION.'/';
	}
}

