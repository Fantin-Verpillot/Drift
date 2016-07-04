<?php

namespace BottleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BottleBundle\Entity\BottleAdmin;
use \Faker\Factory as Faker;

class LoadBottleAdminData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $faker = Faker::create();
        $bottleAdmins = array(
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => "2016-06-08",
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => "2016-07-05",
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 2,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => "2016-07-10",
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => "2016-07-11",
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => $faker->dateTimeThisYear($max = 'now'),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => "2016-07-08",
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 2,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => $faker->dateTimeThisYear($max = 'now'),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => $faker->dateTimeThisYear($max = 'now'),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => $faker->dateTimeThisYear($max = 'now'),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => $faker->dateTimeThisYear($max = 'now'),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 2,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => $faker->dateTimeThisYear($max = 'now'),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => $faker->dateTimeThisYear($max = 'now'),
            ),
        );

        foreach ($bottleAdmins as $key => $value) {
            $bottleAdmin = new BottleAdmin();
            $bottleAdmin->setFkReceiver($value['fkReceiver']);
            $bottleAdmin->setFkTransmitter($value['fkTransmitter']);
            $bottleAdmin->setState($value['state']);
            $bottleAdmin->setMessage($value['message']);
            $bottleAdmin->setImage($value['image']);
            $bottleAdmin->setType($value['type']);

            $em->persist($bottleAdmin);
            $this->addReference('BottleAdmin'.$key, $bottleAdmin);
        }
        $em->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}