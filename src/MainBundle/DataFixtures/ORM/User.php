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
                'username'      => 'transmitter',
                'password'      => 'password',
                'email'         => $faker->email,
                'roles'         => array('ROLE_USER'),
                'experience'    => 170,
                'level'         => 2,
            ),
            array(
                'username'      => 'receiver',
                'password'      => 'password',
                'email'         => $faker->email,
                'roles'         => array('ROLE_USER'),
                'experience'    => 40,
                'level'         => 1,
            ),
            array(
                'username'      => 'admin',
                'password'      => 'password',
                'email'         => $faker->email,
                'roles'         => array('ROLE_ADMIN', 'ROLE_USER'),
                'experience'    => 0,
                'level'         => 1,
            ),
        );

        foreach ($users as $key => $value) {
            $user = new User();
            $user->setUsername($value['username']);
            $user->setPassword($value['password']);
            $user->setEmail($value['email']);
            $user->setRoles($value['roles']);
            $user->setExperience($value['experience']);
            $user->setLevel($value['level']);
            $user->setIsActive(true);

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