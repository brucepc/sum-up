<?php

namespace BPCI\SumUp;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class SumUp
{
	const VERSION = 'v0.1';
	const ENTRYPOINT = 'https://api.sumup.com/';

	/**
	 * @return ClientInterface
	 */
	static function getClient(): ClientInterface
	{
		return new Client(
			[
				'base_uri' => self::getEntrypoint(),
				'timeout' => 2
			]
		);
	}

	static function getEntrypoint(): string
	{
		return self::ENTRYPOINT.self::VERSION.'/';
	}
}

