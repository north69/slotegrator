<?php

namespace Sweepstakes\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_prizes")
 **/
class UserPrize
{
    public const TYPE_MONEY = 1;
    public const TYPE_BONUSES = 2;
    public const TYPE_GIFTS = 3;

    private static $type_names = [
        self::TYPE_MONEY   => 'money',
        self::TYPE_BONUSES => 'bonus',
        self::TYPE_GIFTS   => 'gift',
    ];

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
     * @ORM\Column(type="integer")
     **/
    private $object_id;

    /**
     * @ORM\Column(type="integer")
     **/
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     **/
    private $date_won;

    public static function typeToString(int $type): string
    {
        return self::$type_names[$type];
    }

    public function getId()
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

    public function getObjectId(): int
    {
        return $this->object_id;
    }

    public function setObjectId(int $object_id): void
    {
        $this->object_id = $object_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getDateWon(): int
    {
        return $this->date_won;
    }

    public function setDateWon($date_won): void
    {
        $this->date_won = $date_won;
    }

}