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
    private $left;
}