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
        //$Allbottles2 = $bottles->findByState(3);
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId() && $bottle->getState() == 3) {
                $allBottles[] = $bottle;
            }
        }
        return $allBottles;
    }
}
