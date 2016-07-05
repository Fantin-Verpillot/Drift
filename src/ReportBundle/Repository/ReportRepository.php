<?php

namespace ReportBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ReportRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReportRepository extends EntityRepository
{
    public function getReportByState($state) {
        $qb = $this->createQueryBuilder('r')
            ->select('r.id as reportId, r.message as reportMessage, b.message, b.image, u.id as userId, u.username')
            ->join('r.fkBottle', 'b')
            ->join('b.fkTransmitter', 'u')
            ->where('r.state = :state')
            ->setParameter(':state', $state);

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
