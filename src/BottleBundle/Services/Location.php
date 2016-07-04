<?php

namespace BottleBundle\Services;

class Location
{
    public function getLocationByIP($IP)
    {
        try {
            $json = file_get_contents('http://ipinfo.io/' . $IP);
            $obj = json_decode($json);
            if (!empty($obj)) {
                return explode(",", $obj->loc);
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}