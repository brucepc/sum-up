<?php

namespace BPCI\SumUp\SDK;

class Context
{
    /**
     * Entrypoint to api
     *
     * @var string
     */
    private $entrypoint = 'https://api.sumup.com';

    /**
     * API Version
     *
     * @var string
     */
    private $version = 'v0.1';

    /**
     * Index to use the right uri
     * 
     * @var number
     */
    private $uriIndexToUse = 0;

    /**
     * id
     *
     * @var string
     */
    private $id;

    /**
     * name
     *
     * @var string
     */
    private $name;

    /**
     * client_id
     *
     * @var string
     */
    private $clientId;

    /**
     * client_secret
     *
     * @var string
     */
    private $clientSecret;

    /**
     * application_type
     * web|android|ios|other
     *
     * @var string
     */
    private $applicationType;

    /**
     * redirect_uris
     *
     * @var array
     */
    private $redirectUris;

    /**
     * cors_uris
     *
     * @var array
     */
    private $corsUris;

    function __construct($context = []){
        $this->id = $context['id'] ?? null;
        $this->name = $context['name'] ?? null;
        $this->clientId = $context['client_id'] ?? null;
        $this->clientSecret = $context['client_secret'] ?? null;
        $this->applicationType = $context['application_type'] ?? null;
        $this->redirectUris = $context['redirect_uris'] ?? null;
        $this->corsUris = $context['cors_uris'] ?? null;
    }

    /**
     * Load Context From file  
     * the file must have only json context inside.
     *
     * @param string $filePath
     * @return Context
     */
    public static function loadContextFromFile(string $filePath): Context{
        if(!file_exists($filePath)){
            throw new Exception\FileNotFoundException('Context file not found: '.$filePath, 404, null, $filePath);
        }

        $contents = file_get_contents($filePath);
        $context_array = json_decode($contents, true);

        if($context_array === null){
            throw new Exception\MalformedJsonException('JSON sintax error.');
        }

        return new Context($context_array);
    }

    public function setIndexUri(number $index)
    {
        $this->uriIndexToUser;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getClientId()
    {
        return $this->clientId;
    }
    
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    
    public function getApplicationType()
    {
        return $this->applicationType;
    }
    
    public function getRedirectUris()
    {
        return $this->redirectUris;
    }

    public function getRedirectUri()
    {
        return $this->redirectUris[$this->uriIndexToUse];
    }
    
    public function getCorsUris()
    {
        return $this->corsUris;
    }

    public function getAPIVersion()
    {
        return $this->version;
    }

    public function getEntrypoint()
    {
        return $this->entrypoint;
    }
}