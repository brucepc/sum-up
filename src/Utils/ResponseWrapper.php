<?php
namespace BPCI\SumUp\Utils;

use GuzzleHttp\Psr7\Response;
use Symfony\Component\DependencyInjection\Tests\Compiler\A;

class ResponseWrapper
{
    /**
     * @var Response $response
     */
    private $response;

    /**
     * 
     */
    function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get value from response 
     * @return null|mixed
     */
    function get(string $propertyPath)
    {
        $propertyTree = explode('.', $propertyPath);
        $size = count($propertyTree);
        $data = $this->response->json();
        for($i=0; $i<$size;$i++)
        {
            if(!isset($data[$propertyTree[$i]]))
            {
                return null;
            }
            $data = $data[$propertyTree[$i]];
        }

        return $data;
    }

    function hydrate(&$object, $data = null)
    {
        if($data === null){
            $data = $this->response->json();
        }

        foreach($data as $prop => $value){
            $method = 'set'.replate('_', '', ucwords($prop, '_'));
            if(method_exists($object, $method)){
                $object->$method($value);
            }else{
                error_log('BPCI\SumUp Lib Error: Method '.get_class($object).'::'.$method.' does not exists!');
            }
        }
    }
}