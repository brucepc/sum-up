<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 26/02/18
 * Time: 16:42
 */

namespace BPCI\SumUp\Traits;


interface ClientInterface
{
    /**
     * @param string $action
     * @param $object
     * @param string|null $endpoint
     * @return bool|null
     */
    public function request(string $action, $object, string $endpoint = null):? bool;
}
