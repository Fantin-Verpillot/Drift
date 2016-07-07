<?php
namespace BottleBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BottleTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testPendingBottle()
    {
        echo "\n[BOTTLE] Test pending bottle... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $user = $userRepository->findAll()[1];
        $bottle = $bottleRepository->getPendingBottle($user);
        $this->assertEquals($bottle, null);
        echo "OK\n";
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}