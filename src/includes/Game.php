<?php

class Game {
	var $settings = array();

	public function __construct() {

	}

	public function getSetting($key) {
		if (!empty($this->settings)) {
			if (!isset($this->settings[$key])) {
				global $core;
				Core::raiseError('Tried to access game setting "' . $key . '", which does not exist.');
			}

			return $this->settings[$key];
		} else {
			global $db;

			$sql = 'SELECT * FROM `pfrog_settings`';
			$result = $db->query($sql);

			foreach ($result->fetchAll() as $setting) {
				$this->settings[$setting['key']] = $setting['value'];
			}

			return $this->getSetting($key);
		}
	}
}

$game = new Game();

?>