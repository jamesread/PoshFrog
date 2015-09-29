<?php
/*******************************************************************************

  Copyright (C) 2004-2006 xconspirisist (xconspirisist@gmail.com)

  This file is part of pFrog.

  pFrog is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  pFrog is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with pFrog; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*******************************************************************************/

define('BOX_RED', "red");
define('BOX_GREEN', "green");
define('BOX_YELLOW', "yellow");
define('BOX_BLUE', "blue");
define('BOX_NULL', "");

function getProgramName() {
	return 'pfrog';
}

function get_turns($username) {
	return getTurns($username);
}

function getTurns($username) {
	$waitTimePerTurn = 100;

	$turns = array (
			'time' => null,
			'total' => null,
			'used' => null,
			'remaining' => null
	);

	if ($username == \libAllure\Session::getUser()->getUsername()) {
		$registerd = \libAllure\Session::getUser()->getData('registered');
	} else {
		global $db;

		$sql = 'SELECT `usedturns`, `registerd` FROM `pfrog_users` WHERE "' . $username . '" LIMIT 1 ';
		$result = $db->query($sql);
		$result = $result->fetchRow();
		$registerd = $result['registerd'];
		$turns['used'] = $result['usedTurns'];
	}

	$now = time();
	$timelapse = ($now - $registerd);

	$blocks = $timelapse / $waitTimePerTurn;
	$temp = explode ('.', $blocks);

	if (strlen($temp[1]) == 1) { $temp[1] = $temp[1] . 0; }

	$time_left = $waitTimePerTurn - $temp[1];

	$temp[0] = ($temp[0] - $turns['used']);

	$turns['time'] = $time_left;
    $turns['total'] = $blocks;
    $turns['total_turns'] = $blocks;
	$turns['remaining'] = $temp[0];

	return $turns;
}

function popup ($text, $url) {
	echo "<a href=\"#\" onclick=\"return popitup('$url')\">$text</a>";
}

function infobox($content) {
	echo $content;
}

function startBox($name, $color) {
	echo "<div class = \"box " . $color . "-box\">";
	echo "<h2 class = \"" . $color . "-box\">" . $name . "</h2>";
	echo "<div class = \"boxContent\">";
}

function stopBox($color) {
	echo "</div>";
	echo "</div><br />";
}

/*
 * Flattening a multi-dimensional array into a
 * single-dimensional one. The resulting keys are a
 * string-separated list of the original keys:
 *
 * a[x][y][z] becomes a[implode(sep, array(x,y,z))]
 */

function array_flatten($array) {
  $result = array();
  $stack = array();
  array_push($stack, array("", $array));

  while (count($stack) > 0) {
    list($prefix, $array) = array_pop($stack);

    foreach ($array as $key => $value) {
      $new_key = $prefix . strval($key);

      if (is_array($value))
        array_push($stack, array($new_key . '.', $value));
      else
        $result[$new_key] = $value;
    }
  }

  return $result;
}

function inAdminMode() {
	if (!isset($_SESSION['admin_mode'])) {
		return false;
	}

	return $_SESSION['admin_mode'];
}

function redirect($url, $reason) {
	global $core;
	$core->redirect($url, $reason);
}

function db_query($sql) {
	$stmt = \libAllure\DatabaseFactory::getInstance()->prepare($sql);
	$stmt->execute();

	if (strpos("SELECT", $sql) !== FALSE) {
		return $stmt->fetchAll();
	}
}

?>
