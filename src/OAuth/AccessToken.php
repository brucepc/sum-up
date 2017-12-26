<?php

namespace BPCI\SumUp\SDK\OAuth;

class AccessToken
{
    private $token;
    private $type;
    private $expiration;
    private $scope = [
        'payments',
        'user.app-settings',
        'transactions.history',
        'user.profile_readonly'
    ];

    /**
     * @param string $token
     * @param string $type
     * @param integer $expiresIn
     */
    function __construct(string $token, string $type, int $expiresIn, string $scope = null){
        $this->token = $token;
        $this->type = $type;
        $this->expiration = time() + $expiresIn;
        if($scope!==null) {
            $this->scope = $scope;
        }
    }

    /**
     * Check if token is valid
     *
     * @return boolean
     */
    function isValid(): bool
    {
        return time() > $this->expiration;
    }

    /**
     * getToken
     *
     * @return string
     */
    function getToken(): string
    {
        return $this->token;
    }

    /**
     * getType
     *
     * @return string
     */
    function getType(): string
    {
        return $this->type;
    }

    /**
     * Get Expiration
     *
     * @return integer
     */
    function getExpiration(): int
    {
        return $this->expiration;
    }

    /**
     * Get scope
     *
     * @return Array
     */
    function getScope(): Array
    {
        return $this->scope;
    }

    /**
     * Check if token can access one or more scope
     *
     * @param string $scope[,$scope[,$scope[,...]]]
     * @return boolean
     */
    function canAccess(string $scope){
        $scopes = func_get_args();
        $diff = array_diff($scopes, $this->scope);
        return count($diff)>0;
    }
}
