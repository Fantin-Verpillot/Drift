<?php
namespace UserBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
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
    
    public function testEarnExperience()
    {
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $userRepository->earnExperience($userLuigi, 5);
        $this->assertEquals($userLuigi->getExperience(), 45);
        $this->assertEquals($userLuigi->getLevel(), 1);
    }

    public function testLevelUp()
    {
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $userRepository->earnExperience($userLuigi, 5);
        $this->assertEquals($userLuigi->getExperience(), 0);
        $this->assertEquals($userLuigi->getLevel(), 2);
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