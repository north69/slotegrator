<?php

namespace Core;

class DIContainer
{
    public const DEPENDENCY_DB = 'db';

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
            self::DEPENDENCY_DB => new \PDO($_ENV['DATABASE_DSN'], 'root', $_ENV['MYSQL_ROOT_PASSWORD']),
        ];
    }

    public function get(string $dependency)
    {
        if (!isset($this->container[$dependency])) {
            throw new \Exception("dependency `{$dependency}` has not been set");
        }
        return $this->container[$dependency];
    }

}