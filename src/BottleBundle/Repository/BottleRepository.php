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
        $allBottles = [];
        foreach ($bottles as $bottle) {
            if ($bottle->getFkTransmitter()->getId() !== $userConnected->getId() && $bottle->getState() == 3) {
                $allBottles[] = $bottle;
            }
        }

            return $allBottles;
    }

    public function getAverageMark($userConnected){
        $bottles = $this->findByFkTransmitter($userConnected);
        $avg = 0;
        $count = 0;
        foreach ($bottles as $bottle) {
            if ($bottle->getMark() !== null){
                $avg += $bottle->getMark();
                $count++;
            }
        }
        if ($count !== 0)
            return $avg/$count;

        return $count; // $count must be equal to 0
    }

    public function getTransmittedBottle($userConnected){
        $bottles = $this->findByFkTransmitter($userConnected);
        foreach ($bottles as $bottle) {
            if ($bottle->getState() >= 2){
                $allBottles[] = $bottle;
            }
        }
        return $allBottles;
    }

    public function countTransmittedBottle($userConnected) {
        $bottles = $this->findByFkTransmitter($userConnected);
        foreach ($bottles as $bottle) {
            if ($bottle->getState() >= 2){
                $allBottles[] = $bottle;
            }
        }
        return count($allBottles);
    }

    public function countReceivedBottle($userConnected) {
        $bottles = $this->findByFkReceiver($userConnected);
        return count($bottles);
    }

    public function countEmojiByBottle($userConnected) {
        $bottles = $this->findByFkTransmitter($userConnected);

    }
}
