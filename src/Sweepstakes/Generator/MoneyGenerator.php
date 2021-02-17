<?php

namespace Sweepstakes\Generator;

use Core\DIContainer;
use Doctrine\ORM\EntityManager;
use Sweepstakes\Entity\AccountTransaction;
use Sweepstakes\Entity\SweepstakesAccount;
use Sweepstakes\Entity\UserPrize;

class MoneyGenerator implements GeneratorInterface
{
    private const MIN_SUM = 10;
    private const MAX_SUM = 100;

    /** @var EntityManager $em */
    private $em;
    /** @var SweepstakesAccount $account */
    private $account;
    private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
        $this->em = DIContainer::i()->get('em');
        $this->account = $this->em->getRepository(SweepstakesAccount::class)->findOneBy(['type' => SweepstakesAccount::TYPE_MONEY]);
    }

    public function isAvailable(): bool
    {
        return $this->account->getFree() >= self::MIN_SUM;
    }

    public function generate()
    {
        $prize_sum = rand(self::MIN_SUM, self::MAX_SUM);
        $spent_money = $this->account->getSpent();
        $this->account->setSpent($spent_money + $prize_sum);
        $free_money = $this->account->getFree();
        $this->account->setFree($free_money - $prize_sum);
        $this->em->persist($this->account);

        $transaction = new AccountTransaction();
        $transaction->setSum($prize_sum);
        $transaction->setType(AccountTransaction::TYPE_MONEY);
        $transaction->setDateCreated(time());
        $this->em->persist($transaction);
        $this->em->flush();

        $user_prize = new UserPrize();
        $user_prize->setUserId($this->user_id);
        $user_prize->setType(UserPrize::TYPE_MONEY);
        $user_prize->setObjectId($transaction->getId());
        $user_prize->setDateWon(time());
        $this->em->persist($user_prize);

        $this->em->flush();
    }
}