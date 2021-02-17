<?php

namespace Sweepstakes\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="account_transactions")
 **/
class AccountTransaction
{
    public const TYPE_MONEY = SweepstakesAccount::TYPE_MONEY;
    public const TYPE_BONUSES = SweepstakesAccount::TYPE_BONUSES;

    public static function getTypeByAccountType(int $type): int
    {
        return $type;
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @ORM\Column(type="integer")
     **/
    private $type;

    /**
     * @ORM\Column(type="integer")
     **/
    private $date_created;

    /**
     * @ORM\Column(type="float")
     **/
    private $sum;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getDateCreated(): int
    {
        return $this->date_created;
    }

    public function setDateCreated(int $date_created): void
    {
        $this->date_created = $date_created;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): void
    {
        $this->sum = $sum;
    }
}