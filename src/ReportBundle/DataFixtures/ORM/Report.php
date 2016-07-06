<?php

namespace ReportBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ReportBundle\Entity\Report;
use \Faker\Factory as Faker;

class LoadReportData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $faker = Faker::create();
        $reports = array(
            array(
                'fkBottle'  => $this->getReference('Bottle0'),
                'state'     => 0,
                'message'   => null,
            ),
            array(
                'fkBottle'  => $this->getReference('Bottle3'),
                'state'     => 0,
                'message'   => $faker->realText(100),
            ),
            array(
                'fkBottle'  => $this->getReference('Bottle2'),
                'state'     => 1,
                'message'   => $faker->realText(100),
            ),
            array(
                'fkBottle'  => $this->getReference('Bottle6'),
                'state'     => 2,
                'message'   => $faker->realText(100),
            ),
        );

        foreach ($reports as $key => $value) {
            $report = new Report();
            $report->setFkBottle($value['fkBottle']);
            $report->setMessage($value['message']);
            $report->setState($value['state']);

            $em->persist($report);
            $this->addReference('Report'.$key, $report);
        }

        $em->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}