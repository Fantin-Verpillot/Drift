<?php

namespace BottleBundle\Services;

//use Doctrine\ORM\EntityManager;
//use Symfony\Component\DependencyInjection\ContainerInterface as Container;


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

    function getClientIpEnv() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}