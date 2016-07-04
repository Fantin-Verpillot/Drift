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
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'help',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => null
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'info',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(500),
                'image'             => null,
                'type'              => 'warning',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
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