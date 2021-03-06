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
                'weight'    => 30,
                'image'     => 'fa-smile-o'
            ),
            array(
                'name'      => 'Angry',
                'weight'    => 0,
                'image'     => 'fa-fire'
            ),
            array(
                'name'      => 'Sad',
                'weight'    => 0,
                'image'     => 'fa-frown-o'
            ),
            array(
                'name'      => 'Shocked',
                'weight'    => 0,
                'image'     => 'fa-exclamation-circle'
            ),
            array(
                'name'      => 'In love',
                'weight'    => 50,
                'image'     => 'fa-heart'
            ),
            array(
                'name'      => 'Smitten',
                'weight'    => 40,
                'image'     => 'fa-meh-o'
            ),
            array(
                'name'      => 'Amused',
                'weight'    => 30,
                'image'     => 'fa-hand-peace-o'
            ),
        );

        foreach ($emojis as $key => $value) {
            $emoji = new Emoji();
            $emoji->setName($value['name']);
            $emoji->setWeight($value['weight']);
            $emoji->setImage($value['image']);

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