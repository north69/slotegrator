<?php

namespace Sweepstakes\Generator;

use Core\DIContainer;
use Doctrine\ORM\EntityManager;
use Sweepstakes\Entity\SweepstakesGift;
use Sweepstakes\Entity\UserPrize;

class GiftGenerator implements GeneratorInterface
{

    /** @var EntityManager $em */
    private $em;
    /** @var SweepstakesGift $gift */
    private $gift;
    private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
        $this->em = DIContainer::i()->get('em');
        $query = $this->em->createQuery('SELECT g FROM Sweepstakes\Entity\SweepstakesGift g WHERE g.is_available = 1ORDER BY RAND()');
        $query->setMaxResults(1);
        $this->gift = $query->getSingleResult();
    }

    public function isAvailable(): bool
    {
        return (bool)$this->gift;
    }

    public function generate()
    {
        $this->gift->setIsAvailable(false);
        $this->em->persist($this->gift);

        $user_prize = new UserPrize();
        $user_prize->setUserId($this->user_id);
        $user_prize->setType(UserPrize::TYPE_GIFTS);
        $user_prize->setObjectId($this->gift->getId());
        $user_prize->setDateWon(time());
        $this->em->persist($user_prize);

        $this->em->flush();
    }
}