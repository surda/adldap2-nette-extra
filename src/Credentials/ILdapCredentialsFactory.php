<?php declare(strict_types=1);

namespace Surda\Adldap\Extra\Credentials;

interface ILdapCredentialsFactory
{
    /**
     * @param string $username
     * @param string $password
     * @return LdapCredentials
     */
    public function create(string $username, string $password): LdapCredentials;
}