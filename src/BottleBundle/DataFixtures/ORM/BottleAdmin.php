<?php

namespace BottleBundle\DataFixtures\ORM;

use DateTime;
use DateTimeZone;
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
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 1,
                'message'           => $faker->realText(500),
                'type'              => 'help',
                'received_date'     => null,
            ),
            array(
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 1,
                'message'           => $faker->realText(500),
                'type'              => 'help',
                'received_date'     => null,
            ),
            array(
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'message'           => $faker->realText(500),
                'type'              => 'warning',
                'received_date'     => null,
            ),
            array(
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'message'           => $faker->realText(500),
                'type'              => 'info',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'message'           => $faker->realText(500),
                'type'              => 'info',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'message'           => $faker->realText(500),
                'type'              => 'warning',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'message'           => $faker->realText(500),
                'type'              => 'warning',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User2'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'message'           => $faker->realText(500),
                'type'              => 'info',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
        );

        foreach ($bottleAdmins as $key => $value) {
            $bottleAdmin = new BottleAdmin();
            $bottleAdmin->setFkReceiver($value['fkReceiver']);
            $bottleAdmin->setFkTransmitter($value['fkTransmitter']);
            $bottleAdmin->setState($value['state']);
            $bottleAdmin->setMessage($value['message']);
            $bottleAdmin->setType($value['type']);
            $bottleAdmin->setReceivedDate($value['received_date']);

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