<?php

namespace BottleBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PermissionTest extends WebTestCase
{
    public function testHome()
    {
        echo "\n[PERMISSION] Test home... ";
        $client = static::createClient();
        $container = $client->getContainer();
        $url = $container->get('router')->generate('main_home');
        $client->request('GET', $url);
        $this->assertContains('Redirecting to', $client->getResponse()->getContent());
        echo "OK\n";
    }

    public function testLogin()
    {
        echo "\n[PERMISSION] Test login... ";
        $client = static::createClient();
        $container = $client->getContainer();
        $url = $container->get('router')->generate('login');
        $client->request('GET', $url);
        $this->assertNotContains('Redirecting to', $client->getResponse()->getContent());
        $this->assertContains('/login_check', $client->getResponse()->getContent());
        echo "OK\n";
    }

    public function testRegister()
    {
        echo "\n[PERMISSION] Test register... ";
        $client = static::createClient();
        $container = $client->getContainer();
        $url = $container->get('router')->generate('register');
        $client->request('GET', $url);
        $this->assertNotContains('Redirecting to', $client->getResponse()->getContent());
        $this->assertContains('/register_check', $client->getResponse()->getContent());
        echo "OK\n";
    }
}
