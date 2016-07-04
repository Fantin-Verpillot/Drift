<?php

namespace BottleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BottleRepository extends EntityRepository
{
    public function getPendingBottle($userConnected) {
        $bottles = $this->findByFkReceiver($userConnected);
        foreach ($bottles as $bottle) {
            if ($bottle->getState() === 2) {
                return $bottle;
            }
        }
        return null;
    }

    public function queryBuilderExample() {
        //$this->container->getEntityManager()
        $qb = $this->createQueryBuilder('b')
            ->select('count(b.fkEmoji) as countEmoji, e.id, e.name')
            ->join('b.fkEmoji', 'e')
            ->Where('b.fkTransmitter = 47')
            ->groupBy('b.fkEmoji');
            //->andWhere('e.name = :name_emoji')
            //->setParameter('name_emoji', 'angry')
            //->addOrderBy('b.message', 'asc')
            //->setFirstResult(5)
            //->setMaxResults(10);

        return $qb->getQuery()->getResult();
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

    public function getArchivedBottles($userConnected)
    {
        $bottles = $this->findByFkReceiver($userConnected);
        $bottlesFilter = [];
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId() && $bottle->getState() == 3) {
                $bottlesFilter[] = $bottle;
            }
        }

        return $bottlesFilter;
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
        return count ($this->findByFkTransmitter($userConnected));

    }
}
