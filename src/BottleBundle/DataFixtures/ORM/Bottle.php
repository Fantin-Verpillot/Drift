<?php

namespace BottleBundle\DataFixtures\ORM;

use DateTime;
use DateTimeZone;
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
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => null,
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 1,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => null,
                'longitude'         => null,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => null,
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 2,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => 51.508742,
                'longitude'         => -0.120850,
                'message'           => $faker->realText(500),
                'image'             => 'http://okux.org/wp-content/uploads/2013/07/fond-d-ecran-coucher-de-soleil-en-taille-reelle.jpg',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => null,
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 2,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => 55.60,
                'longitude'         => 1.120850,
                'message'           => $faker->realText(500),
                'image'             => 'http://okux.org/wp-content/uploads/2013/07/fond-d-ecran-coucher-de-soleil-en-taille-reelle.jpg',
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => null,
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 1,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => null,
                'longitude'         => null,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => null,
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User0'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji2'),
                'latitude'          => 48.856614,
                'longitude'         => 2.3522219000000177,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 3,
                'mark'              => 1,
                'fkEmoji'           => $this->getReference('Emoji1'),
                'latitude'          => 48.856614,
                'longitude'         => 2.3522219000000177,
                'message'           => $faker->realText(500),
                'image'             => 'http://img1.mxstatic.com/wallpapers/9c3d9ad540db9c53767569ae2faa15ac_large.jpeg',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 4,
                'mark'              => 1,
                'fkEmoji'           => $this->getReference('Emoji2'),
                'latitude'          => 48.856614,
                'longitude'         => 2.3522219000000177,
                'message'           => $faker->realText(500),
                'image'             => 'http://img1.mxstatic.com/wallpapers/9c3d9ad540db9c53767569ae2faa15ac_large.jpeg',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkReceiver'        => $this->getReference('User1'),
                'fkTransmitter'     => $this->getReference('User2'),
                'state'             => 4,
                'mark'              => 2,
                'fkEmoji'           => $this->getReference('Emoji2'),
                'latitude'          => 48.856614,
                'longitude'         => 2.3522219000000177,
                'message'           => $faker->realText(500),
                'image'             => 'http://img1.mxstatic.com/wallpapers/9c3d9ad540db9c53767569ae2faa15ac_large.jpeg',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
        );

        foreach ($bottles as $key => $value) {
            $bottle = new Bottle();
            $bottle->setFkReceiver($value['fkReceiver']);
            $bottle->setFkTransmitter($value['fkTransmitter']);
            $bottle->setState($value['state']);
            $bottle->setMark($value['mark']);
            $bottle->setFkEmoji($value['fkEmoji']);
            $bottle->setLatitude($value['latitude']);
            $bottle->setLongitude($value['longitude']);
            $bottle->setMessage($value['message']);
            $bottle->setImage($value['image']);
            $bottle->setReceivedDate($value['received_date']);

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