<?php declare(strict_types=1);

namespace Surda\Adldap\Extra\Credentials;

class LdapCredentialsFactory implements ILdapCredentialsFactory
{
    /** @var string */
    private $upnSuffix;

    /** @var string */
    private $upnPrefix;

    /**
     * @param string $upnPrefix
     * @param string $upnSuffix
     */
    public function __construct(string $upnPrefix, string $upnSuffix)
    {
        $this->upnPrefix = $upnPrefix;
        $this->upnSuffix = $upnSuffix;
    }

    /**
     * @param string $username
     * @param string $password
     * @return LdapCredentials
     */
    public function create(string $username, string $password): LdapCredentials
    {
        if (strpos($username, '\\') !== FALSE) {
            [$upn, $username] = explode('\\', $username);
            $dn = sprintf('%s\%s', $upn, $username);
        } elseif (strpos($username, '@') !== FALSE) {
            [$username, $upn] = explode('@', $username);
            $dn = sprintf('%s@%s', $username, $upn);
        } else {
            $dn = sprintf('%s%s%s', $this->upnPrefix, $username, $this->upnSuffix);
        }

        return new LdapCredentials($username, $password, $dn);
    }
}