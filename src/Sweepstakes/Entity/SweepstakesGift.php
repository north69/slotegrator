<?php

namespace Sweepstakes\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sweeptakes_gifts")
 **/
class SweepstakesGift
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @ORM\Column(type="string")
     **/
    private $name;

    /**
     * @ORM\Column(type="boolean")
     **/
    private $is_available;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getIsAvailable()
    {
        return $this->is_available;
    }

    public function setIsAvailable($is_available): void
    {
        $this->is_available = $is_available;
    }

}