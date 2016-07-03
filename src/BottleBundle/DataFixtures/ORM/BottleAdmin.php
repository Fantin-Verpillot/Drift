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
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'help',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 2,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'help',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'help',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 2,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'info',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 0,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 1,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 2,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'message'           => $faker->realText(1000),
                'image'             => null,
                'type'              => 'warning',
            ),
        );

        foreach ($bottleAdmins as $key => $value) {
            $bottleAdmin = new BottleAdmin();
            $bottleAdmin->setMessage($value['fkReceiver']);
            $bottleAdmin->setMessage($value['fkTransmitter']);
            $bottleAdmin->setMessage($value['state']);
            $bottleAdmin->setMessage($value['message']);
            $bottleAdmin->setMessage($value['image']);
            $bottleAdmin->setMessage($value['type']);

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