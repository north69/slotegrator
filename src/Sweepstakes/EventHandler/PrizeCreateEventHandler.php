<?php

namespace Sweepstakes\EventHandler;

use Core\DIContainer;
use Doctrine\ORM\EntityManager;
use Sweepstakes\Generator\GeneratorFactory;
use Sweepstakes\Generator\GeneratorInterface;

class PrizeCreateEventHandler
{
    /** @var EntityManager $em */
    private $em;

    public function __construct()
    {
        $this->em = DIContainer::i()->get('em');
    }

    public function handle(int $user_id): bool
    {
        $generator = $this->getGenerator($user_id);
        if (!$generator) {
            return false;
        }
        $generator->generate();
        return true;
    }

    private function getGenerator(int $user_id): ?GeneratorInterface
    {
        $factory = new GeneratorFactory($user_id);
        $generators = $factory->getAvailableGenerators();
        if (!$generators) {
            return null;
        }
        $generator_key = array_rand($generators, 1);
        return $generators[$generator_key];
    }
}