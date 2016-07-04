<?php

namespace BottleBundle\Services;

//use Doctrine\ORM\EntityManager;
//use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use \Httpful\Request as HttpRequest;


class Location
{
    public function myservice($ip)
    {
        try {
            $url = 'http://ipinfo.io/';
            $json = file_get_contents($url.$ip);
            $obj = json_decode($json);
            if ($obj !== null && $obj !== '' && $obj != false) {
                $loc = explode(",",$obj->loc);
                return $loc;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}