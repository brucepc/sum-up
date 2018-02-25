<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 24/02/18
 * Time: 14:22
 */

namespace BPCI\SumUp\Tests\Traits;


use BPCI\SumUp\Traits\PropertyHandler;
use PHPUnit\Framework\TestCase;

class PropertyHandlerTest extends TestCase
{
	use PropertyHandler;

	protected $property;
	protected $propertyOne;
	protected $propertyTwo;
	protected static $data;

	function setUp(){
		$this::$data = [
			'property' => 'value',
			'property_one' => 'value 1',
		];
	}

	function testSetProperties(){
		$this->fillProperties($this::$data);
		$this->assertEquals($this::$data['property'], $this->getProperty());
		$this->assertEquals($this::$data['property_one'], $this->getPropertyOne());
	}

	function testGetPropertyArray(){
		$this->fillProperties($this::$data);
		$propertyArray = $this->getPropertyArray();
		foreach ($this::$data as $key => $item) {
			$this->assertArrayHasKey($key, $propertyArray);
			$this->assertEquals($propertyArray[$key], $item);
		}
	}

	/**
	 * @return mixed
	 */
	public function getProperty()
	{
		return $this->property;
	}

	/**
	 * @param mixed $property
	 * @return PropertyHandlerTest
	 */
	public function setProperty($property)
	{
		$this->property = $property;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPropertyOne()
	{
		return $this->propertyOne;
	}

	/**
	 * @param mixed $propertyOne
	 * @return PropertyHandlerTest
	 */
	public function setPropertyOne($propertyOne)
	{
		$this->propertyOne = $propertyOne;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPropertyTwo()
	{
		return $this->propertyTwo;
	}

	/**
	 * @param mixed $propertyTwo
	 * @return PropertyHandlerTest
	 */
	public function setPropertyTwo($propertyTwo)
	{
		$this->propertyTwo = $propertyTwo;

		return $this;
	}

}
