<?php

namespace Sweepstakes\Generator;

class GeneratorFactory
{
    private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    private function getAllGenerators(): array
    {
        return [
            new MoneyGenerator($this->user_id),
        ];
    }

    public function getAvailableGenerators(): array
    {
        $result = [];
        foreach ($this->getAllGenerators() as $generator) {
            if (!$generator->isAvailable()) {
                continue;
            }
            $result[] = $generator;
        }
        return $result;
    }
}