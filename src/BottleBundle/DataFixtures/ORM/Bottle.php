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
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => null,
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
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => null,
                'state'             => 1,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => null,
                'longitude'         => null,
                'message'           => $faker->realText(500),
                'image'             => 'http://vignette2.wikia.nocookie.net/nintendo/images/5/5b/Mushroom1.jpg/revision/latest?cb=20111104224030&path-prefix=en',
                'received_date'     => null,
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => null,
                'state'             => 1,
                'mark'              => null,
                'fkEmoji'           => null,
                'latitude'          => null,
                'longitude'         => null,
                'message'           => $faker->realText(500),
                'image'             => 'http://cloud.mmgn.com.s3.amazonaws.com/images/articles/MK7items/coin.jpg',
                'received_date'     => null,
            ),
            // =============================================
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji0'),
                'latitude'          => 48.815553,
                'longitude'         => 2.362594,
                'message'           => $faker->realText(500),
                'image'             => 'http://vignette2.wikia.nocookie.net/nintendo/images/2/28/FireFlower.jpg/revision/latest?cb=20080514012947&path-prefix=en',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji1'),
                'latitude'          => 48.815553,
                'longitude'         => 2.362594,
                'message'           => $faker->realText(500),
                'image'             => 'http://vignette2.wikia.nocookie.net/nintendo/images/2/28/FireFlower.jpg/revision/latest?cb=20080514012947&path-prefix=en',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji2'),
                'latitude'          => 48.815553,
                'longitude'         => 2.362594,
                'message'           => $faker->realText(500),
                'image'             => 'http://vignette2.wikia.nocookie.net/nintendo/images/2/28/FireFlower.jpg/revision/latest?cb=20080514012947&path-prefix=en',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji3'),
                'latitude'          => 48.815553,
                'longitude'         => 2.362594,
                'message'           => $faker->realText(500),
                'image'             => 'http://vignette2.wikia.nocookie.net/nintendo/images/2/28/FireFlower.jpg/revision/latest?cb=20080514012947&path-prefix=en',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji4'),
                'latitude'          => 48.815553,
                'longitude'         => 2.362594,
                'message'           => $faker->realText(500),
                'image'             => 'http://vignette2.wikia.nocookie.net/nintendo/images/2/28/FireFlower.jpg/revision/latest?cb=20080514012947&path-prefix=en',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            // =============================
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji5'),
                'latitude'          => 48.816874,
                'longitude'         => 2.362701,
                'message'           => $faker->realText(500),
                'image'             => 'http://static.giantbomb.com/uploads/original/0/3830/2378775-wiiu_newmariou_4_item01_e3.png',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji6'),
                'latitude'          => 48.816874,
                'longitude'         => 2.362701,
                'message'           => $faker->realText(500),
                'image'             => 'http://static.giantbomb.com/uploads/original/0/3830/2378775-wiiu_newmariou_4_item01_e3.png',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji0'),
                'latitude'          => 48.816874,
                'longitude'         => 2.362701,
                'message'           => $faker->realText(500),
                'image'             => 'http://static.giantbomb.com/uploads/original/0/3830/2378775-wiiu_newmariou_4_item01_e3.png',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji1'),
                'latitude'          => 48.816874,
                'longitude'         => 2.362701,
                'message'           => $faker->realText(500),
                'image'             => 'http://static.giantbomb.com/uploads/original/0/3830/2378775-wiiu_newmariou_4_item01_e3.png',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji2'),
                'latitude'          => 48.816874,
                'longitude'         => 2.362701,
                'message'           => $faker->realText(500),
                'image'             => 'http://static.giantbomb.com/uploads/original/0/3830/2378775-wiiu_newmariou_4_item01_e3.png',
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            //===============
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji0'),
                'latitude'          => 48.820887,
                'longitude'         => 2.359533,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji3'),
                'latitude'          => 48.820887,
                'longitude'         => 2.359533,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji3'),
                'latitude'          => 48.820887,
                'longitude'         => 2.359533,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji3'),
                'latitude'          => 48.820887,
                'longitude'         => 2.359533,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 3,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji4'),
                'latitude'          => 48.820887,
                'longitude'         => 2.359533,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            // ==================
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji4'),
                'latitude'          => 48.821509,
                'longitude'         => 2.357087,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji4'),
                'latitude'          => 48.821509,
                'longitude'         => 2.357087,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji4'),
                'latitude'          => 48.821509,
                'longitude'         => 2.357087,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji4'),
                'latitude'          => 48.821509,
                'longitude'         => 2.357087,
                'message'           => $faker->realText(500),
                'image'             => null,
                'received_date'     => new DateTime('NOW', new DateTimeZone('Europe/Paris')),
            ),
            array(
                'fkTransmitter'     => $this->getReference('User0'),
                'fkReceiver'        => $this->getReference('User1'),
                'state'             => 4,
                'mark'              => 3,
                'fkEmoji'           => $this->getReference('Emoji4'),
                'latitude'          => 48.821509,
                'longitude'         => 2.357087,
                'message'           => $faker->realText(500),
                'image'             => null,
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
            $bottle->setLatitude($value['latitude'] !== null ? rand(2500, 7000) / 100 : $value['latitude']);
            $bottle->setLongitude($value['longitude'] !== null ? rand(100, 10000) / 100 : $value['longitude']);
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