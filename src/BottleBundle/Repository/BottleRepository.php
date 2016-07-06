<?php

namespace BottleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BottleRepository extends EntityRepository
{
    private $em;

    public function getPendingBottle($userConnected) {
        $this->em = $this->getEntityManager();
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $bottle = $bottleAdminRepository->getPendingBottleAdmin($userConnected);
        if ($bottle !== null) {
            return $bottle;
        }

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
        $this->em = $this->getEntityManager();
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $bottle = $bottleAdminRepository->getAvailableBottleAdmin($userConnected);
        if ($bottle !== null) {
            return $bottle;
        }

        $bottles = $this->findByState(1);
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId()) {
                return $bottle;
            }
        }
        return null;
    }



    public function getBottlesSentByUser($userConnected)
    {
        $sent = [];
        $bottles = $this->findByState(2);
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() === $userConnected->getId()) {
                $sent[] = $bottle;
            }
        }
        return $bottles;
    }


   public static function dateCompare($b1, $b2)
    {
        $r1 = $b1->getReceivedDate();
        $r2 = $b2->getReceivedDate();

        if ($r1 === $r2) {
            return 0;
        }
        return ( $r1 > $r2) ? -1 : 1;
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
            if ($bottle->getState() === 3) {
                $userBottles[] = $bottle;
            }
        }

        // then we merge the user's bottle + the one he received from the admin
        $adminBottles = $bottleAdminRepository->getSavedAdminBottles($userConnected);
        $allBottles = $userBottles;

        foreach ($adminBottles as $bottle) {
            $allBottles[] = $bottle;
        }

        // return the sorted array
       usort($allBottles, array('BottleBundle\Repository\BottleRepository','dateCompare'));
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

    public function getSentBottle($userConnected){
        $bottles = $this->findByFkTransmitter($userConnected);
        $bottlesFilter = array();
        foreach ($bottles as $bottle) {
            if ($bottle->getState() >= 1){
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
            ->select('count(b.fkEmoji) as countEmoji, e.name, e.image, e.id')
            ->join('b.fkEmoji', 'e')
            ->Where('b.fkTransmitter = :userId')
            ->setParameter(':userId', $userConnected->getId())
            ->groupBy('b.fkEmoji');

        $result = $qb->getQuery()->getResult();
        $emojiRepository = $this->getEntityManager()->getRepository('BottleBundle:Emoji');
        $emojis = $emojiRepository->findAll();

        $emojiResults = array();
        foreach ($emojis as $emoji) {
            $emojiResults[$emoji->getId()] = array(
                'name' => $emoji->getName(),
                'count' => 0,
                'image' => $emoji->getImage()
            );
        }
        foreach ($result as $e) {
            $emojiResults[$e['id']]['count'] = $e['countEmoji'];
        }

        return $emojiResults;
    }
}
