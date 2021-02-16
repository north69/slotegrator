<?php

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once dirname(__DIR__).'/config/bootstrap.php';

$entity_manager = \Core\DIContainer::i()->get('em');
$helper_set = \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entity_manager);

$config = new PhpFile(dirname(__DIR__).'/config/migrations.php');

$dependency_factory = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entity_manager));

$cli = ConsoleRunner::createApplication($helper_set,[
    new DiffCommand($dependency_factory),
    new ExecuteCommand($dependency_factory),
    new GenerateCommand($dependency_factory),
    new MigrateCommand($dependency_factory),
    new StatusCommand($dependency_factory),
    new VersionCommand($dependency_factory),
]);

return $cli->run();