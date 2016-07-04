<?php

namespace BottleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BottleRepository extends EntityRepository
{
    private $em;

    public function getPendingBottle($userConnected) {
        $bottles = $this->findByFkReceiver($userConnected);
        foreach ($bottles as $bottle) {
            if ($bottle->getState() === 2) {
                return $bottle;
            }
        }
        return null;
    }

    public function getAvailableBottle($userConnected)
    {
        $bottles = $this->findByState(1);
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId()) {
                return $bottle;
            }
        }
        return null;
    }


   public static function cmp($b1, $b2)
    {
        $r1 = $b1->getReceivedDate();
        $r2 = $b2->getReceivedDate();
        if ($b1 == $b2) {
            return 0;
        }
        return ( $b1 < $b2) ? -1 : 1;
    }

    /*
     * Get all users bottles and the ones sent by the admin
     *
     * return an array sorted by received_date of all collected bottles
     * */
    public function getCollectedBottles($userConnected)
    {
        $this->em = $this->getEntityManager();
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');

        $bottles = $this->findByFkReceiver($userConnected);

        // get all user's bottles
        $userBottles = [];
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId() && $bottle->getState() == 3) {
                $userBottles[] = $bottle;
            }
        }

        // then we merge the user's bottle + the one he received from the admin
        $adminBottles = $bottleAdminRepository->getSavedAdminBottles($userConnected);

        $allBottles = $userBottles;

        foreach ($adminBottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId() && $bottle->getState() == 3) {
                $allBottles[] = $bottle;
            }
        }

        // return the sorted array
       //return usort($allBottles, array('BottleBundle\Repository\BottleRepository','cmp'));
        return $allBottles;
    }

    public function getAverageMark($userConnected){
        $bottles = $this->findByFkTransmitter($userConnected);
        $avg = 0;
        foreach ($bottles as $bottle) {
            if ($bottle->getMark() !== null){
                $avg += $bottle->getMark();
            }
        }
        $count = count($bottles);
        return $count !== 0 ? $avg / $count : 0;
    }

    public function getTransmittedBottle($userConnected){
        $bottles = $this->findByFkTransmitter($userConnected);
        $bottlesFilter = array();
        foreach ($bottles as $bottle) {
            if ($bottle->getState() >= 2){
                $bottlesFilter[] = $bottle;
            }
        }
        return $bottlesFilter;
    }

    public function countTransmittedBottle($userConnected) {
        return count($this->getTransmittedBottle($userConnected));
    }

    public function countReceivedBottle($userConnected) {
        return count($this->findByFkReceiver($userConnected));
    }

    public function countEmojiByBottle($userConnected) {
        $qb = $this->createQueryBuilder('b')
            ->select('count(b.fkEmoji) as countEmoji, e.name')
            ->join('b.fkEmoji', 'e')
            ->Where('b.fkTransmitter = :userId')
            ->setParameter(':userId', $userConnected->getId())
            ->groupBy('b.fkEmoji');

        $result = $qb->getQuery()->getResult();
        $emojiRepository = $this->getEntityManager()->getRepository('BottleBundle:Emoji');
        $emojis = $emojiRepository->findAll();
        foreach ($emojis as $emoji) {
            $allEmoji[$emoji->getName()] = 0;
        }

        foreach ($result as $e) {
            $allEmoji[$e['name']] = (int) $e['countEmoji'];
        }

        return $allEmoji;
    }
}
