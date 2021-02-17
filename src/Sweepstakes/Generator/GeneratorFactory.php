<?php

namespace Sweepstakes\Generator;

use Sweepstakes\Entity\SweepstakesAccount;

class GeneratorFactory
{
    private const MONEY_MIN_SUM = 10;
    private const MONEY_MAX_SUM = 100;

    private const BONUSES_MIN_SUM = 20;
    private const BONUSES_MAX_SUM = 200;

    private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    private function getAllGenerators(): array
    {
        return [
            new MoneyAndBonusesGenerator($this->user_id, SweepstakesAccount::TYPE_MONEY, self::MONEY_MIN_SUM, self::MONEY_MAX_SUM),
            new MoneyAndBonusesGenerator($this->user_id, SweepstakesAccount::TYPE_BONUSES, self::BONUSES_MIN_SUM, self::BONUSES_MAX_SUM),
            new GiftGenerator($this->user_id),
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