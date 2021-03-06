<?php

namespace BPCI\SumUp;

class Context implements ContextInterface
{
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

    public function __construct(Array $context = [])
    {
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
    public static function loadContextFromFile(string $filePath): ContextInterface
    {
        if(!file_exists($filePath)){
            throw new Exception\FileNotFoundException('Context file not found: '.$filePath, 404, null, $filePath);
        }

        $contents = file_get_contents($filePath);
        $context_array = json_decode($contents, true);

        if($context_array === null){
            throw new Exception\MalformedJsonException('JSON sintax error.');
        }

        return new self($context_array);
    }

    /**
     * Get context data as array
     *
     * @return Array
     */
    public function getContextData(): Array
    {
        return [
        'id' => $this->getId(),
        'name' => $this->getName(),
        'client_id' => $this->getClientId(),
        'client_secret' => $this->getClientSecret(),
        'application_type' => $this->getApplicationType(),
        'redirect_uris' => $this->getRedirectUris(),
        'cors_uris' => $this->getCorsUris()
        ];
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
    
    public function getCorsUris()
    {
        return $this->corsUris;
    }

    /**
     * Set Index of URI to use on requests
     *
     * @param int $index
     * @return ContextInterface
     */
    public function setIndexUri(int $index): ContextInterface
    {
        $this->uriIndexToUse = $index;

        return $this;
    }

    public function getRedirectUri()
    {
        return $this->redirectUris[$this->uriIndexToUse];
    }

}