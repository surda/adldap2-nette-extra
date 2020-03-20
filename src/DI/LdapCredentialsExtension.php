<?php declare(strict_types=1);

namespace Surda\Adldap\Extra\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;
use Surda\Adldap\Extra\Credentials\LdapCredentialsFactory;

/**
 * @property-read stdClass $config
 */
final class LdapCredentialsExtension extends CompilerExtension
{
    public static function createSchema(): Schema
    {
        return Expect::structure([
            'accountPrefix' => Expect::string()
                ->default(''),
            'accountSuffix' => Expect::string()
                ->default(''),
        ]);
    }

    public function getConfigSchema(): Schema
    {
        return self::createSchema();
    }

    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $config = $this->config;

        $builder->addDefinition($this->prefix('factory'))
            ->setFactory(LdapCredentialsFactory::class, [$config->accountPrefix, $config->accountSuffix]);
    }
}