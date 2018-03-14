<?php

namespace BPCI\SumUp\Customer;

/**
 * Class Address
 * @package BPCI\SumUp\Customer
 */
class Address implements AddressInterface
{
	/**
	 * First address line
	 *
	 * @var string $line1
	 */
	protected $line1;
	/**
	 * Second address line
	 *
	 * @var string
	 */
	protected $line2;
	/**
	 * Address Country
	 *
	 * @var string
	 */
	protected $country;
	/**
	 * Address postal code
	 *
	 * @var string
	 */
	protected $postalCode;
	/**
	 * Address City
	 *
	 * @var string
	 */
	protected $city;
	/**
	 * @var string
	 */
	protected $countryEnName;
	/**
	 * @var string
	 */
	protected $countryNativeName;
	/**
	 * @var integer
	 */
	protected $regionId;
	/**
	 * @var string
	 */
	protected $regionName;
	/**
	 * @var string
	 */
	protected $postCode;
	/**
	 * @var string
	 */
	protected $landline;
	/**
	 * @var string
	 */
	protected $addressLine1;
	/**
	 * @var string
	 */
	protected $addressLine2;
	/**
	 * Address State
	 *
	 * @var string
	 */
	protected $state;

	/**
	 * Address constructor.
	 * @param array|null $data
	 */
    public function __construct(?array $data = [])
	{
		$this->setAddressLine1($data['address_line1']??null);
		$this->setAddressLine2($data['address_line2']??null);
		$this->setCity($data['city']??null);
		$this->setCountry($data['country']??null);
		$this->setCountryEnName($data['country_en_name']??null);
		$this->setCountryNativeName($data['country_native_name']??null);
		$this->setRegionId($data['region_id']??null);
		$this->setRegionName($data['region_name']??null);
		$this->setPostCode($data['post_code']??null);
		$this->setLandline($data['landline']??null);
		$this->setLine1($data['line1']??null);
		$this->setLine2($data['line2']??null);
		$this->setPostalCode($data['postal_code']??null);
		$this->setState($data['state']??null);
	}

	/**
	 * Get $line1
	 *
	 * @return  string
	 */
	public function getLine1(): ?string
	{
		return $this->line1;
	}

	/**
	 * Set $line1
	 *
	 * @param  string  $line1  $line1
	 *
	 * @return  AddressInterface
	 */
	public function setLine1(?string $line1): AddressInterface
	{
		$this->line1 = $line1;

		return $this;
	}

	/**
	 * Get second address line
	 *
	 * @return  string
	 */
	public function getLine2(): ?string
	{
		return $this->line2;
	}

	/**
	 * Set second address line
	 *
	 * @param  string  $line2  Second address line
	 *
	 * @return  AddressInterface
	 */
	public function setLine2(?string $line2): AddressInterface
	{
		$this->line2 = $line2;

		return $this;
	}

	/**
	 * Get address Country
	 *
	 * @return  string
	 */
	public function getCountry(): ?string
	{
		return $this->country;
	}

	/**
	 * Set address Country
	 *
	 * @param  string  $country  Address Country
	 *
	 * @return  AddressInterface
	 */
	public function setCountry(?string $country): AddressInterface
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * Get address postal code
	 *
	 * @return  string
	 */
	public function getPostalCode(): ?string
	{
		return $this->postalCode;
	}

	/**
	 * Set address postal code
	 *
	 * @param  string  $postalCode  Address postal code
	 *
	 * @return  AddressInterface
	 */
	public function setPostalCode(?string $postalCode): AddressInterface
	{
		$this->postalCode = $postalCode;

		return $this;
	}

	/**
	 * Get address City
	 *
	 * @return  string
	 */
	public function getCity(): ?string
	{
		return $this->city;
	}

	/**
	 * Set address City
	 *
	 * @param  string  $city  Address City
	 *
	 * @return  AddressInterface
	 */
	public function setCity(?string $city): AddressInterface
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCountryEnName():? string
	{
		return $this->countryEnName;
	}

	/**
	 * @param mixed $countryEnName
	 * @return AddressInterface
	 */
	public function setCountryEnName($countryEnName): AddressInterface
	{
		$this->countryEnName = $countryEnName;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCountryNativeName():? string
	{
		return $this->countryNativeName;
	}

    /**
     * @param mixed $countryNativeName
     * @return AddressInterface
     */
	public function setCountryNativeName(?string $countryNativeName): AddressInterface
	{
		$this->countryNativeName = $countryNativeName;

		return $this;
	}

	/**
     * @return int|null
	 */
    public function getRegionId():? int
	{
		return $this->regionId;
	}

	/**
     * @param int|null $regionId
     * @return AddressInterface
	 */
    public function setRegionId(?int $regionId): AddressInterface
	{
		$this->regionId = $regionId;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getRegionName():? string
	{
		return $this->regionName;
	}

	/**
	 * @param string|null $regionName
	 * @return AddressInterface
	 */
	public function setRegionName(?string $regionName): AddressInterface
	{
		$this->regionName = $regionName;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPostCode():? string
	{
		return $this->postCode;
	}

	/**
	 * @param string|null $postCode
	 * @return AddressInterface
	 */
	public function setPostCode(?string $postCode): AddressInterface
	{
		$this->postCode = $postCode;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLandline():? string
	{
		return $this->landline;
	}

	/**
	 * @param string|null $landline
	 * @return AddressInterface
	 */
	public function setLandline(?string $landline): AddressInterface
	{
		$this->landline = $landline;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAddressLine1():? string
	{
		return $this->addressLine1;
	}

	/**
	 * @param string|null $addressLine1
	 * @return AddressInterface
	 */
	public function setAddressLine1(?string $addressLine1): AddressInterface
	{
		$this->addressLine1 = $addressLine1;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAddressLine2():? string
	{
		return $this->addressLine2;
	}

	/**
	 * @param string|null $addressLine2
	 * @return AddressInterface
	 */
	public function setAddressLine2(?string $addressLine2): AddressInterface
	{
		$this->addressLine2 = $addressLine2;

		return $this;
	}

	/**
	 * Get address State
	 *
	 * @return  string|null
	 */
	public function getState(): ?string
	{
		return $this->state;
	}

	/**
	 * Set address State
	 *
	 * @param  string|null  $state  Address State
	 *
	 * @return  AddressInterface
	 */
	public function setState(?string $state): AddressInterface
	{
		$this->state = $state;

		return $this;
	}
}
