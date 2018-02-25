<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 24/02/18
 * Time: 11:49
 */

namespace BPCI\SumUp\Exception;


use Throwable;

class NotAllowedProperty extends \RuntimeException
{
	public function __construct($object, $property, Throwable $previous = null)
	{
		$message = sprintf('Not allowed property %s into %s class!', $property,get_class($object));
		parent::__construct($message, 100, $previous);
	}
}
