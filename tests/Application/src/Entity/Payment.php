<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 17/03/18
 * Time: 16:47
 */

namespace BPCI\SumUp\Tests\Entity;


use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\ArrayObject;

/**
 * Class Payment
 * @package BPCI\SumUp\Tests\Application\src\Entity
 * @ORM\Table
 * @ORM\Entity
 */
class Payment extends ArrayObject
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;

//    /**
//     * @var string $checkoutReference
//     * @ORM\Column(name="checkout_reference", type="string")
//     */
//    protected $checkoutReference;
//
//    /**
//     * @var string $payToEmail
//     * @ORM\Column(name="pay_to_email", type="string", nullable=true)
//     */
//    protected $payToEmail;
//
//    /**
//     * @return string
//     */
//    public function getCheckoutReference():? string
//    {
//        return $this->checkoutReference;
//    }
//
//    /**
//     * @param string $checkoutReference
//     * @return Payment
//     */
//    public function setCheckoutReference(string $checkoutReference): Payment
//    {
//        $this->checkoutReference = $checkoutReference;
//
//        return $this;
//    }
//
//    /**
//     * @return string
//     */
//    public function getPayToEmail():? string
//    {
//        return $this->payToEmail;
//    }
//
//    /**
//     * @param string $payToEmail
//     * @return Payment
//     */
//    public function setPayToEmail(string $payToEmail): Payment
//    {
//        $this->payToEmail = $payToEmail;
//
//        return $this;
//    }
//
}