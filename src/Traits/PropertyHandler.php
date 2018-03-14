<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 24/02/18
 * Time: 12:33
 */

namespace BPCI\SumUp\Traits;


trait PropertyHandler
{
	/**
	 * @param array $data
	 */
    public function fillProperties(array $data): void
	{
		foreach ($data as $p => $v)
		{
			$this->fillProperty($p, $v);
		}
	}

	/**
	 * @param string $property
	 * @param mixed $value
	 */
    public function fillProperty(string $property, $value): void
	{
		$property = lcfirst(str_replace('_', '', ucwords($property, '_')));
		if(property_exists(__CLASS__, $property))
		{
			$method = sprintf('set%s', ucfirst($property));
			$this->{$method}($value);
		}
	}

	/**
	 * @return array
	 */
    public function getPropertyArray(): array
	{
		$reflection = new \ReflectionClass(__CLASS__);
		$properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);
		$data = [];
		foreach($properties as $property){
			$prop_name = $property->getName();
			$method = sprintf('get%s', ucfirst($prop_name));
			$form_name = strtolower(preg_replace('/[A-Z]/', '_$0', $prop_name));
			if($reflection->hasMethod($method)){
				$data[$form_name] = $this->{$method}();
			}
		}
		return $data;
	}

}
