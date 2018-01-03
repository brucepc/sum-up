<?php
namespace BPCI\SumUp\Utils;

use GuzzleHttp\Psr7\Response;

class ResponseWrapper
{
    /**
     * @var Response $response
     */
    private $response;

    /**
     * @var Array $suppressedPaths
     */
    private $suppressedPaths;

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

    /**
     * Set path to be suppressed on hydrate action
     *
     * @param Array $path
     * @return self
     */
    function setSuppressPaths(string $path, string $path2): self
    {
        $this->suppressedPaths = get_func_args();
        return $this;
    }

    function hydrate(&$object, $data = null)
    {
        if($data === null){
            $data = $this->response->json();
        }

        $suppressedData = $this->suppressDataPaths($data);

        foreach($suppressedData as $prop => $value)
        {
            $method = 'set'.replate('_', '', ucwords($prop, '_'));
            if(method_exists($object, $method)){
                $object->$method($value);
            }else{
                error_log('BPCI\SumUp Lib Error: Method '.get_class($object).'::'.$method.' does not exists!');
            }
        }
    }

    private function suppressDataPaths(Array $data)
    {
        $suppressedData = [];
        $suppressedPaths = $this->suppressedPaths;
        array_map(function($value, $path) use ($suppressedPaths, $suppressedData) {
            foreach($suppressedPaths as $sPath){
                $suppressedData[replace($sPath, '', $path)] = $value;
            }
        }, $data);

        return $suppressedData;
    }
}