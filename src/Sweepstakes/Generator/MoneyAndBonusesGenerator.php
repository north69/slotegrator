<?php

namespace Sweepstakes\Generator;

use Core\DIContainer;
use Doctrine\ORM\EntityManager;
use Sweepstakes\Entity\AccountTransaction;
use Sweepstakes\Entity\SweepstakesAccount;
use Sweepstakes\Entity\UserPrize;

class MoneyAndBonusesGenerator implements GeneratorInterface
{
    /** @var EntityManager $em */
    private $em;
    /** @var SweepstakesAccount $account */
    private $account;

    private $user_id;
    private $type;
    private $min_sum;
    private $max_sum;

    public function __construct(int $user_id, int $type, int $min_sum, int $max_sum)
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->min_sum = $min_sum;
        $this->max_sum = $max_sum;
        $this->em = DIContainer::i()->get('em');
        $this->account = $this->em->getRepository(SweepstakesAccount::class)->findOneBy(['type' => $this->type]);
    }

    public function isAvailable(): bool
    {
        return $this->account->getFree() >= $this->min_sum;
    }

    public function generate()
    {
        $prize_sum = rand($this->min_sum, $this->max_sum);
        $spent_money = $this->account->getSpent();
        $this->account->setSpent($spent_money + $prize_sum);
        $free_money = $this->account->getFree();
        $this->account->setFree($free_money - $prize_sum);
        $this->em->persist($this->account);

        $transaction = new AccountTransaction();
        $transaction->setSum($prize_sum);
        $transaction->setType(AccountTransaction::getTypeByAccountType($this->type));
        $transaction->setDateCreated(time());
        $this->em->persist($transaction);
        $this->em->flush();

        $user_prize = new UserPrize();
        $user_prize->setUserId($this->user_id);
        $type = $this->type == SweepstakesAccount::TYPE_MONEY ? UserPrize::TYPE_MONEY : UserPrize::TYPE_BONUSES;
        $user_prize->setType($type);
        $user_prize->setObjectId($transaction->getId());
        $user_prize->setDateWon(time());
        $this->em->persist($user_prize);

        $this->em->flush();
    }
}