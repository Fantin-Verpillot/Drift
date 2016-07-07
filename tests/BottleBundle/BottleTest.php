<?php
namespace BottleBundle;

use BottleBundle\Entity\Bottle;
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
        echo ") [BOTTLE] Test pending bottle... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $bottle = $bottleRepository->getPendingBottle($userLuigi);
        $this->assertEquals($bottle, null);
        echo "OK\n";
    }

    public function testAvailableBottle()
    {
        echo ") [BOTTLE] Test available bottle from luigi... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $bottle = $bottleRepository->getAvailableBottle($userLuigi);
        $this->assertNotEquals($bottle, null);
        echo "OK\n";
    }

    public function testNonAvailableBottle()
    {
        echo ") [BOTTLE] Test non available bottle from mario... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userMario = $userRepository->findAll()[0];
        $bottle = $bottleRepository->getAvailableBottle($userMario);
        $this->assertEquals($bottle, null);
        echo "OK\n";
    }

    public function testBottlesSentByMario()
    {
        echo ") [BOTTLE] Test bottles sent by mario... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userMario = $userRepository->findAll()[0];
        $bottle = $bottleRepository->getBottlesSentByUser($userMario);
        $this->assertNotEquals($bottle, null);
        echo "OK\n";
    }

    public function testBottlesSentByLuigi()
    {
        echo ") [BOTTLE] Test bottles sent by luigi... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $bottle = $bottleRepository->getBottlesSentByUser($userLuigi);
        $this->assertNotEquals($bottle, null);
        $this->assertEquals($bottle, array());
        echo "OK\n";
    }

    public function testDateCompareEqual()
    {
        echo ") [BOTTLE] Test date compare equal... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        $bottle1 = new Bottle();
        $date1 = new \DateTime('NOW');
        $date1->setTime(0, 0, 0);
        $bottle1->setReceivedDate($date1);

        $bottle2 = new Bottle();
        $date2 = new \DateTime('NOW');
        $date2->setTime(0, 0, 0);
        $bottle2->setReceivedDate($date2);

        $res = $bottleRepository->dateCompare($bottle1, $bottle2);
        $this->assertEquals($res, 0);
        echo "OK\n";
    }

    public function testDateCompareSup()
    {
        echo ") [BOTTLE] Test date compare superior... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $bottle1 = new Bottle();
        $bottle1->setReceivedDate(new \DateTime('TOMORROW'));
        $bottle2 = new Bottle();
        $bottle2->setReceivedDate(new \DateTime('NOW'));

        $res = $bottleRepository->dateCompare($bottle1, $bottle2);
        $this->assertEquals($res, -1);
        echo "OK\n";
    }

    public function testDateCompareInf()
    {
        echo ") [BOTTLE] Test date compare inferior... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $bottle2 = new Bottle();
        $bottle2->setReceivedDate(new \DateTime('TOMORROW'));
        $bottle1 = new Bottle();
        $bottle1->setReceivedDate(new \DateTime('NOW'));

        $res = $bottleRepository->dateCompare($bottle1, $bottle2);
        $this->assertEquals($res, 1);
        echo "OK\n";
    }

    public function testCollectedBottleLuigi()
    {
        echo ") [BOTTLE] Test collected bottle from Luigi... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $bottle = $bottleRepository->getAvailableBottle($userLuigi);
        $this->assertNotEquals($bottle, null);
        $this->assertNotEquals($bottle, array());
        echo "OK\n";
    }

    public function testCollectedBottleMario()
    {
        echo ") [BOTTLE] Test collected bottle from Mario... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userMario = $userRepository->findAll()[0];
        $bottle = $bottleRepository->getAvailableBottle($userMario);
        $this->assertEquals($bottle, null);
        echo "OK\n";
    }

    public function testAverageMarkMario()
    {
        echo ") [BOTTLE] Test average mark for Mario... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userMario = $userRepository->findAll()[0];
        $mark = $bottleRepository->getAverageMark($userMario);
        $this->assertEquals($mark, 2.6086956521739131);
        echo "OK\n";
    }

    public function testAverageMarkLuigi()
    {
        echo ") [BOTTLE] Test average mark for Luigi... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $mark = $bottleRepository->getAverageMark($userLuigi);
        $this->assertEquals($mark, 0);
        echo "OK\n";
    }

    public function testCountTransmittedBottleLuigi()
    {
        echo ") [BOTTLE] Test count transmitted bottle for Luigi... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $count = $bottleRepository->countTransmittedBottle($userLuigi);
        $this->assertEquals($count, 0);
        echo "OK\n";
    }

    public function testCountTransmittedBottleMario()
    {
        echo ") [BOTTLE] Test count received bottle for Mario... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userMario = $userRepository->findAll()[0];
        $count = $bottleRepository->countTransmittedBottle($userMario);
        $this->assertEquals($count, 20);
        echo "OK\n";
    }

    public function testCountReceivedBottleLuigi()
    {
        echo ") [BOTTLE] Test count received bottle for Luigi... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $count = $bottleRepository->countReceivedBottle($userLuigi);
        $this->assertEquals($count, 20);
        echo "OK\n";
    }

    public function testCountReceivedBottleMario()
    {
        echo ") [BOTTLE] Test count transmitted bottle for Mario... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userMario = $userRepository->findAll()[0];
        $count = $bottleRepository->countReceivedBottle($userMario);
        $this->assertEquals($count, 0);
        echo "OK\n";
    }

    public function testSentBottlesLuigi()
    {
        echo ") [BOTTLE] Test sent bottles for Luigi... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userLuigi = $userRepository->findAll()[1];
        $bottle = $bottleRepository->getSentBottle($userLuigi);
        $this->assertNotEquals($bottle, null);
        $this->assertEquals($bottle, array());
        echo "OK\n";
    }

    public function testSentBottlesMario()
    {
        echo ") [BOTTLE] Test sent bottles for Mario... ";
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');
        $userMario = $userRepository->findAll()[0];
        $bottle = $bottleRepository->getSentBottle($userMario);
        $this->assertNotEquals($bottle, null);
        $this->assertNotEquals($bottle, array());
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