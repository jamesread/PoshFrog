<?php

namespace pfrog;

use libAllure\DatabaseFactory;

class Game
{
    var $settings = array();

    public function __construct()
    {
    }

    public function getSetting($key)
    {
        if (empty($this->settings)) {
            $sql = 'SELECT * FROM `settings`';
            $stmt = DatabaseFactory::getInstance()->prepare($sql);
            $stmt->execute();

            foreach ($stmt->fetchAll() as $setting) {
                $this->settings[$setting['key']] = $setting['value'];
            }
        }

        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        } else {
            return 0;
    //        throw new Exception('Tried to access game setting "' . $key . '", which does not exist.');
        }
    }

    public function getResourceNames()
    {
        return ['gold'];
    }

    public function getItemTypes() 
    {
        return ['business', 'worker', 'accessory'];
    }

    public function stepTurns() 
    {
        $goldPerTurn = 1;

        $lastTurn = date_create(gud('lastStep'));
        $lastTurn->setTimezone(new \DateTimezone('UTC'));
        $lastTurn = $lastTurn->getTimestamp();
        $now = time();

        $diff = $now - $lastTurn;

        var_dump($lastTurn, $now, $diff);
        var_dump($lastTurn, $now, $now - $lastTurn);
    }
}
