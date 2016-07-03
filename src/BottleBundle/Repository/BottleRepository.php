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

    public function getBottleToOpen($userConnected)
    {
        $bottles = $this->findByFkReceiver(null);
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId()) {
                return $bottle;
            }
        }
        return null;
    }
}
