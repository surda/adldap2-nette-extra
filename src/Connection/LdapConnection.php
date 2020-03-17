<?php declare(strict_types=1);

namespace Surda\Adldap\Extra\Connection;

use Adldap;
use Surda\Ldap\ConnectionInterface;
use Surda\Ldap\Exception\BindException;
use Surda\Ldap\Exception\InvalidCredentialsException;

class LdapConnection implements ConnectionInterface
{
    /** @var Adldap\AdldapInterface */
    private $adldap;

    /** @var Adldap\Connections\ProviderInterface */
    private $provider;

    /** @var bool */
    private $bound = FALSE;

    /**
     * @param Adldap\AdldapInterface $adldap
     */
    public function __construct(Adldap\AdldapInterface $adldap)
    {
        $this->adldap = $adldap;
    }

    /**
     * @inheritDoc
     */
    public function attempt(string $username, string $password, bool $bindAsUser = FALSE): bool
    {
        if ($this->provider === NULL) {
            $this->connect();
        }

        try {
            if ($this->provider->auth()->attempt($username, $password)) {
                return TRUE;
            }
        }
        catch (Adldap\Auth\BindException $e) {
            throw new BindException($e->getMessage(), $e->getCode());
        }
        catch (Adldap\Auth\UsernameRequiredException $e) {
            throw new InvalidCredentialsException($e->getMessage(), $e->getCode());
        }
        catch (Adldap\Auth\PasswordRequiredException $e) {
            throw new InvalidCredentialsException($e->getMessage(), $e->getCode());
        }

        return FALSE;
    }

    /**
     * @inheritDoc
     */
    public function bind(?string $dn = NULL, ?string $password = NULL): void
    {
        $this->bound = FALSE;

        if ($this->provider === NULL) {
            $this->connect();
        }

        try {
            $this->provider->auth()->bind((string) $dn, (string) $password);
        }
        catch (Adldap\Auth\BindException $e) {
            throw new BindException($e->getMessage(), $e->getCode());
        }
        catch (Adldap\Connections\ConnectionException $e) {
            throw new BindException($e->getMessage(), $e->getCode());
        }

        $this->bound = TRUE;
    }

    /**
     * @inheritDoc
     */
    public function isBound(): bool
    {
        return $this->bound;
    }

    private function connect(): void
    {
        if ($this->provider !== NULL) {
            return;
        }

        $this->provider = $this->adldap->connect();
    }
}