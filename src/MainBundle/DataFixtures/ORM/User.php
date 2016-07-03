<?php

namespace BottleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\User;
use \Faker\Factory as Faker;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $faker = Faker::create();
        $users = array(
            array(
                'login'         => 'transmitter',
                'password'      => 'password',
                'email'         => $faker->email,
                'role'          => 1,
                'experience'    => 1000,
                'level'         => 2,
            ),
            array(
                'login'         => 'receiver',
                'password'      => 'password',
                'email'         => $faker->email,
                'role'          => 1,
                'experience'    => 100,
                'level'         => 1,
            ),
            array(
                'login'         => 'admin',
                'password'      => 'password',
                'email'         => $faker->email,
                'role'          => 0,
                'experience'    => 0,
                'level'         => 1,
            ),
        );

        foreach ($users as $key => $value) {
            $user = new User();
            $user->setLogin($value['login']);
            $user->setPassword($value['password']);
            $user->setEmail($value['email']);
            $user->setRole($value['role']);
            $user->setExperience($value['experience']);
            $user->setLevel($value['level']);

            $em->persist($user);
            $this->addReference('User'.$key, $user);
        }
        $em->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}