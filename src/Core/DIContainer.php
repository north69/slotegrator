<?php

namespace Core;

use Core\Doctrine\Rand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DIContainer
{
    public const DEPENDENCY_DB = 'db';
    public const DEPENDENCY_ENTITY_MANAGER = 'em';

    private static $instance;

    private $container = [];

    private function __construct()
    {
        $this->initDependencies();
    }

    public static function i(): self
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function initDependencies()
    {
        $this->container = [
            self::DEPENDENCY_DB => $this->getPDO(),
            self::DEPENDENCY_ENTITY_MANAGER => $this->getEntityManager(),
        ];
    }

    public function get(string $dependency)
    {
        if (!isset($this->container[$dependency])) {
            throw new \Exception("dependency `{$dependency}` has not been set");
        }
        return $this->container[$dependency];
    }

    private function getPDO(): \PDO
    {
        return new \PDO($_ENV['DATABASE_DSN'], 'root', $_ENV['MYSQL_ROOT_PASSWORD']);
    }

    private function getEntityManager(): EntityManager
    {
        $is_dev_mode = $_ENV['APP_ENV'] == 'dev';
        $config = Setup::createAnnotationMetadataConfiguration([PROJECT_ROOT.'/src'], $is_dev_mode, null, null, false);
        $config->setSchemaAssetsFilter(
            static function ($asset) {
                return preg_match('~^(?!users_)~', $asset);
            });
        $config->addCustomNumericFunction('RAND', Rand::class);
        $conn = [
            'driver' => 'pdo_mysql',
            'server_version' => '8.0',
            'charset' => 'utf8mb4',
            'default_table_options'=> [
                'charset' => 'utf8mb4',
                'collate' => 'utf8mb4_unicode_ci'
            ],
            'url' => $_ENV['DATABASE_URL'],
        ];
        return \Doctrine\ORM\EntityManager::create($conn, $config);
    }

}