<?php

namespace Sweepstakes\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sweeptakes_accounts")
 **/
class SweepstakesAccount
{
    public const TYPE_MONEY = 1;
    public const TYPE_BONUSES = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @ORM\Column(type="smallint")
     **/
    private $type;

    /**
     * @ORM\Column(type="float")
     **/
    private $spent;

    /**
     * @ORM\Column(type="float")
     **/
    private $free;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getSpent()
    {
        return $this->spent;
    }

    public function setSpent($spent): void
    {
        $this->spent = $spent;
    }

    public function getFree()
    {
        return $this->free;
    }

    public function setFree($free): void
    {
        $this->free = $free;
    }

}