<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 17/03/18
 * Time: 16:44
 */

namespace BPCI\SumUp\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * Class PaymentToken
 * @package BPCI\SumUp\Tests\Application\src\Entity
 * @ORM\Table
 * @ORM\Entity
 */
class PaymentToken extends Token
{
}