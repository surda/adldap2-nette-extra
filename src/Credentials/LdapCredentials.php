<?php declare(strict_types=1);

namespace Surda\Adldap\Extra\Credentials;

class LdapCredentials
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $dn;

    /**
     * @param string $username
     * @param string $password
     * @param string $dn
     */
    public function __construct(string $username, string $password, string $dn)
    {
        $this->username = $username;
        $this->password = $password;
        $this->dn = $dn;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDn(): string
    {
        return $this->dn;
    }
}