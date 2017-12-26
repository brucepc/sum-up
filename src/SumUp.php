<?php 

namespace BPCI\SumUp\SDK;

class SumUp {
    private $context;
    static function loadContext(string $context)
    {

    }

    public function authenticate($context){
        $client = new \GuzzleHttp\Client([
            'https://api.sumup.com/'
        ]);
        $res = $client->request('GET', '/authorize',
    [

    ]);
    }
}