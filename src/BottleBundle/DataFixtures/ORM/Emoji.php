<?php

namespace BottleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BottleBundle\Entity\Bottle;

class LoadEmojiData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $emojis = array(
            array(
                'name'  => 'Happy'
            ),
            array(
                'name'  => 'Angry'
            ),
            array(
                'name'  => 'Sad'
            ),
            array(
                'name'  => 'Affected'
            ),
            array(
                'name'  => 'In love'
            ),
        );

        foreach ($emojis as $key => $value) {
            $emoji = new Bottle();
            $emoji->setMessage($value['name']);

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