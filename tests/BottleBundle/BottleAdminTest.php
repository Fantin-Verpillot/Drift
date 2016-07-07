<?php
namespace BottleBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BottleAdmin extends WebTestCase
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


    public function testAvailableBottleAdminLuigi()
    {
        echo ") [ADMIN_BOTTLE] Test available bottles admin for Luigi... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userLuigi = $userRepository->findAll()[1];
        $bottlesAvailableAdmin = $bottleAdminRepository->getAvailableBottleAdmin($userLuigi);
        $this->assertNotEquals($bottlesAvailableAdmin, null);
        echo "OK\n";
    }

    public function testAvailableBottleAdminMario()
    {
        echo ") [ADMIN_BOTTLE] Test available bottles admin for Mario... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userMario = $userRepository->findAll()[0];
        $bottlesAvailableAdmin = $bottleAdminRepository->getAvailableBottleAdmin($userMario);
        $this->assertEquals($bottlesAvailableAdmin, null);
        echo "OK\n";
    }

    public function testNoAvailableBottleAdminForAdmin()
    {
        echo ") [ADMIN_BOTTLE] Test not available bottles admin for Admin... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userAdmin = $userRepository->findAll()[0];
        $bottlesAvailableAdmin = $bottleAdminRepository->getAvailableBottleAdmin($userAdmin);
        $this->assertEquals($bottlesAvailableAdmin, null);
        echo "OK\n";
    }


    public function testPendingBottleAdminLuigi()
    {
        echo ") [ADMIN_BOTTLE] Test pending bottles admin for Luigi... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userLuigi = $userRepository->findAll()[1];
        $bottlesPendingAdmin = $bottleAdminRepository->getPendingBottleAdmin($userLuigi);
        $this->assertEquals($bottlesPendingAdmin, null);
        echo "OK\n";
    }

    public function testPendingBottleAdminMario()
    {
        echo ") [ADMIN_BOTTLE] Test pending bottles admin for Mario... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userMario = $userRepository->findAll()[0];
        $bottlesPendingAdmin = $bottleAdminRepository->getPendingBottleAdmin($userMario);
        $this->assertEquals($bottlesPendingAdmin, null);
        echo "OK\n";
    }

    public function testNoPendingBottleAdminForAdmin()
    {
        echo ") [ADMIN_BOTTLE] Test no pending bottles admin for Admin... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userAdmin = $userRepository->findAll()[2];
        $bottlesPendingAdmin = $bottleAdminRepository->getPendingBottleAdmin($userAdmin);
        $this->assertEquals($bottlesPendingAdmin, null);
        echo "OK\n";
    }

    public function testSavedBottlesAdminLuigi()
    {
        echo ") [ADMIN_BOTTLE] Test saved bottles admin for Luigi... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userLuigi = $userRepository->findAll()[1];
        $bottlesSavedAdmin = $bottleAdminRepository->getSavedAdminBottles($userLuigi);
        $this->assertNotEquals($bottlesSavedAdmin, null);
        echo "OK\n";
    }

    public function testSavedBottlesAdminMario()
    {
        echo ") [ADMIN_BOTTLE] Test saved bottles admin for Mario... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userMario = $userRepository->findAll()[0];
        $bottlesSavedAdmin = $bottleAdminRepository->getSavedAdminBottles($userMario);
        $this->assertNotEquals($bottlesSavedAdmin, null);
        echo "OK\n";
    }

    public function testNoSavedBottlesAdminForAdmin()
    {
        echo ") [ADMIN_BOTTLE] Test no saved bottles admin for Admin... ";
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $userAdmin = $userRepository->findAll()[2];
        $bottlesSavedAdmin = $bottleAdminRepository->getSavedAdminBottles($userAdmin);
        $this->assertNotEquals($bottlesSavedAdmin, null);
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