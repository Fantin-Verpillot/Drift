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
