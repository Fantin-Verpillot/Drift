<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    private $em;

    public function earnExperience($user, $gain)
    {
        $this->em = $this->getEntityManager();

        $experience = $user->getExperience();
        $level = $user->getLevel();
        $experience += $gain;
        $changed = false;

        while ($experience >= $level * $level * 50) {
            $experience -= $level * $level * 50;
            ++$level;
            $changed = true;
        }

        $user->setExperience($experience);
        $user->setLevel($level);
        $this->em->persist($user);
        $this->em->flush();
        return $changed;
    }

    public function getAllOtherUsers($userConnected)
    {
        $users = $this->findAll();
        for ($i = 0; $i < count($users); ++$i) {
            if ($users[$i]->getId() === $userConnected->getId()) {
                unset($users[$i]);
            }
            break;
        }
        return $users;
    }
}
