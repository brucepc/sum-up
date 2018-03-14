<?php

namespace BPCI\SumUp\OAuth;

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
     * @param string|null $scope
     */
    public function __construct(string $token, string $type, int $expiresIn, string $scope = null)
    {
        $this->token = $token;
        $this->type = $type;
        $this->expiration = time() + $expiresIn;

        if($scope !== null) {
            $this->scope = $scope;
        }
    }

    /**
     * Check if token is valid
     *
     * @return boolean
     */
    public function isValid(): bool
    {
        return $this->getToken() !== '' && time() < $this->expiration;
    }

    /**
     * getToken
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * getType
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get Expiration
     *
     * @return integer
     */
    public function getExpiration(): int
    {
        return $this->expiration;
    }

    /**
     * Get scope
     *
     * @return array
     */
    public function getScope(): array
    {
        return $this->scope;
    }

    /**
     * Check if token can access one or more scope
     *
     * @param string $scope[,$scope[,$scope[,...]]]
     * @return boolean
     */
    public function canAccess(string $scope)
    {
        $scopes = func_get_args();
        $diff = array_diff($scopes, $this->scope);
        return count($diff)>0;
    }
}
