<?php declare(strict_types=1);

namespace Surda\Adldap\Extra\DI;

use Nette\DI\CompilerExtension;
use Surda\Adldap\Extra\Connection\LdapConnection;

final class LdapConnectionExtension extends CompilerExtension
{
    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('factory'))
            ->setFactory(LdapConnection::class);
    }
}