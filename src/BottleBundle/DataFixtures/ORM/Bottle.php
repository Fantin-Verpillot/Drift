<?php

namespace BottleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BottleBundle\Entity\Bottle;
use \Faker\Factory as Faker;

class LoadBottleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $faker = Faker::create();
        $bottles = array(
            array(
                'fkReceiver'        => null,
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 0,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => null,
                'longitude'         => null,
                'message'           => $faker->realText(1000),
                'image'             => null,
            ),
            array(
                'fkReceiver'        => null,
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 1,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => null,
                'longitude'         => null,
                'message'           => $faker->realText(1000),
                'image'             => null,
            ),
            array(
                'fkReceiver'        => null,
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 1,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => null,
                'longitude'         => null,
                'message'           => $faker->realText(1000),
                'image'             => 'http://okux.org/wp-content/uploads/2013/07/fond-d-ecran-coucher-de-soleil-en-taille-reelle.jpg',
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 2,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji0'),
                'latitude'          => 48.856614,
                'longitude'         => 2.3522219000000177,
                'message'           => $faker->realText(1000),
                'image'             => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'mark'              => 1,
                'fkEmoji'           => $this->getReference('Emoji1'),
                'latitude'          => 48.856614,
                'longitude'         => 2.3522219000000177,
                'message'           => $faker->realText(1000),
                'image'             => 'http://img1.mxstatic.com/wallpapers/9c3d9ad540db9c53767569ae2faa15ac_large.jpeg',
            ),
        );

        foreach ($bottles as $key => $value) {
            $bottle = new Bottle();
            $bottle->setMessage($value['fkReceiver']);
            $bottle->setMessage($value['fkTransmitter']);
            $bottle->setMessage($value['state']);
            $bottle->setMessage($value['mark']);
            $bottle->setMessage($value['fkEmoji']);
            $bottle->setMessage($value['latitude']);
            $bottle->setMessage($value['longitude']);
            $bottle->setMessage($value['message']);
            $bottle->setMessage($value['image']);

            $em->persist($bottle);
            $this->addReference('Bottle'.$key, $bottle);
        }
        $em->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}