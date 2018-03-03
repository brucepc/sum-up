<?php

namespace BPCI\SumUp\Customer;

class Customer implements CustomerInterface
{
	/**
	 * Customer SumUp ID
	 *
	 * @var string
	 */
	protected $customerId;

	/**
	 * Customer Name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Customer phone
	 *
	 * @var string
	 */
	protected $phone;

	/**
	 * Cusomter address
	 *
	 * @var AddressInterface
	 */
	protected $address;

	function __construct(?array $data = [])
	{
		$this->setCustomerId($data['customer_id']??null);
		$personal_details = $data['personal_details']??$data;
		$this->setName($personal_details['name']??null);
		$this->setPhone($personal_details['phone']??null);
		$this->setAddress(new Address($personal_details['address']??null));
	}

	/**
	 * Get customer SumUp ID
	 *
	 * @return  string
	 */
	public function getCustomerId(): ?string
	{
		return $this->customerId;
	}

	/**
	 * Set customer SumUp ID
	 *
	 * @param  string $customerId Customer SumUp ID
	 * @return CustomerInterface
	 */
	public function setCustomerId(?string $customerId): CustomerInterface
	{
		$this->customerId = $customerId;

		return $this;
	}

	/**
	 * Get customer Name
	 *
	 * @return  string
	 */
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * Set customer Name
	 *
     * @param  string $name Customer Name
     * @return Customer|CustomerInterface
	 */
	public function setName(?string $name): CustomerInterface
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get customer phone
	 *
	 * @return  string
	 */
	public function getPhone(): ?string
	{
		return $this->phone;
	}

	/**
	 * Set customer phone
	 *
     * @param  string $phone Customer phone
     * @return Customer|CustomerInterface
	 */
	public function setPhone(?string $phone): CustomerInterface
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * Get cusomter address
	 *
	 * @return  AddressInterface
	 */
	public function getAddress(): AddressInterface
	{
		return $this->address;
	}

	/**
	 * Set cusomter address
	 *
	 * @param AddressInterface $address
	 * @return Customer|CustomerInterface
	 */
	public function setAddress(AddressInterface $address): CustomerInterface
	{
		$this->address = $address;
		return $this;
	}

}
