<?php

namespace BottleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BottleAdminRepository extends EntityRepository
{

    public function getAvailableBottleAdmin($userConnected) {
        $bottles = $this->findByFkReceiver($userConnected);
        foreach ($bottles as $bottle) {
            if ($bottle->getState() === 1) {
                return $bottle;
            }
        }
        return null;
    }

    public function getPendingBottleAdmin($userConnected) {
        $bottles = $this->findByFkReceiver($userConnected);
        foreach ($bottles as $bottle) {
            if ($bottle->getState() === 2) {
                return $bottle;
            }
        }
        return null;
    }

    public function getSavedAdminBottles($userConnected)
    {
        $bottles = $this->findByFkReceiver($userConnected);
        $allBottles = [];
        foreach ($bottles as $bottle) {
            if ($bottle->getState() == 3) {
                $allBottles[] = $bottle;
            }
        }
        return $allBottles;
    }
}
