<?php

namespace BottleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BottleBundle\Entity\Emoji;

class LoadEmojiData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $emojis = array(
            array(
                'name'      => 'Happy',
                'weight'    => 30
            ),
            array(
                'name'      => 'Angry',
                'weight'    => 0
            ),
            array(
                'name'      => 'Sad',
                'weight'    => 0
            ),
            array(
                'name'      => 'Shocked',
                'weight'    => 0
            ),
            array(
                'name'      => 'In love',
                'weight'    => 50
            ),
            array(
                'name'      => 'Smitten',
                'weight'    => 40
            ),
        );

        foreach ($emojis as $key => $value) {
            $emoji = new Emoji();
            $emoji->setName($value['name']);
            $emoji->setWeight($value['weight']);

            $em->persist($emoji);
            $this->addReference('Emoji'.$key, $emoji);
        }
        $em->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}