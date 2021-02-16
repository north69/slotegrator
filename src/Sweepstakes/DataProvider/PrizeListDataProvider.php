<?php

namespace Sweepstakes\DataProvider;

use Core\DIContainer;
use Doctrine\ORM\EntityManager;
use Sweepstakes\Entity\AccountTransaction;
use Sweepstakes\Entity\SweepstakesGift;
use Sweepstakes\Entity\UserPrize;

class PrizeListDataProvider
{
    private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function getData(): array
    {
        /** @var EntityManager $em */
        $em = DIContainer::i()->get('em');

        /** @var UserPrize $user_prize */
        $user_prize = $em->getRepository(UserPrize::class)->findOneBy(['user_id' => $this->user_id]);

        if (!$user_prize) {
            return [];
        }

        $data = [
            'user_id' => $user_prize->getUserId(),
            'type' => UserPrize::typeToString($user_prize->getType()),
        ];

        if ($user_prize->getType() == UserPrize::TYPE_MONEY) {
            /** @var AccountTransaction $transaction */
            $transaction = $em->getRepository(AccountTransaction::class)->findOneBy(['id' => $user_prize->getObjectId()]);
            $sum = $transaction->getSum();
            $data['title'] = $sum.'$';
        }

        if ($user_prize->getType() == UserPrize::TYPE_BONUSES) {
            /** @var AccountTransaction $transaction */
            $transaction = $em->getRepository(AccountTransaction::class)->findOneBy(['id' => $user_prize->getObjectId()]);
            $sum = $transaction->getSum();
            $data['title'] = $sum.' of schmeckles';
        }

        if ($user_prize->getType() == UserPrize::TYPE_GIFTS) {
            /** @var SweepstakesGift $gift */
            $gift = $em->getRepository(SweepstakesGift::class)->findOneBy(['id' => $user_prize->getObjectId()]);
            $data['title'] = $gift->getName();
        }

        return [
            $data,
        ];
    }
}