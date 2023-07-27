<?php

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
}
