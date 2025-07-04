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

use libAllure\DatabaseFactory;
use libAllure\Session;
use libAllure\Shortcuts as LA;

function getProgramName()
{
    return 'PoshFrog';
}

function gud($key)
{
    return Session::getUser()->getData($key);
}

function getTurns()
{
    $waitTimePerTurn = 100;

    $turns = array (
        'time' => null,
        'total' => null,
        'used' => null,
        'remaining' => null
    );

    $registerd = Session::getUser()->getData('registered');
    $registerd = strtotime($registerd);

    $now = time();
    $timelapse = ($now - $registerd);

    $time_left = floor($timelapse / $waitTimePerTurn);
    $blocks = 0;

    $turns['time'] = $time_left;
    $turns['total'] = $blocks;
    $turns['total_turns'] = $blocks;
    $turns['remaining'] = $blocks;

    return $turns;
}

function popup($text, $url)
{
    echo "<a href=\"#\" onclick=\"return popitup('$url&popup=true;')\">$text</a>";
}

function infobox($content)
{
    echo $content;
}

function startBox($name, $color)
{
    echo "<div class = \"box " . $color . "-box\">";
    echo "<h2 class = \"" . $color . "-box\">" . $name . "</h2>";
    echo "<div class = \"boxContent\">";
}

function stopBox($color)
{
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

function array_flatten($array)
{
    $result = array();
    $stack = array();
    array_push($stack, array("", $array));

    while (count($stack) > 0) {
        list($prefix, $array) = array_pop($stack);

        foreach ($array as $key => $value) {
            $new_key = $prefix . strval($key);

            if (is_array($value)) {
                array_push($stack, array($new_key . '.', $value));
            } else {
                $result[$new_key] = $value;
            }
        }
    }

    return $result;
}

function inAdminMode()
{
    if (!isset($_SESSION['admin_mode'])) {
        return false;
    }

    return $_SESSION['admin_mode'];
}

function redirect($url, $reason)
{
    global $core;
    $core->redirect($url, $reason);
}

function db_query($sql)
{
    $stmt = \libAllure\DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute();

    if (strpos("SELECT", $sql) !== false) {
        return $stmt->fetchAll();
    }
}

function showHint()
{
    $sql = "SELECT * FROM `hints` ORDER BY rand() LIMIT 1 ";
    $stmt = \libAllure\DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute();
    $hint = $stmt->fetchRow();

    if ($stmt->numRows() > 0) {
        startBox("Random Game Hint #" . ($hint['id']), BOX_YELLOW);
        echo $hint['content'];
        stopBox(BOX_YELLOW);
    }
}

function getGold() 
{
    return intval(gud('gold'));
}

function adjustUserGold(int $currentAccount, int $bankAccount = 0)
{
    $sql = 'UPDATE users SET gold = (gold + :current), bankGold = (bankGold + :bank) WHERE id = :user';
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->bindValue(':user', Session::getUser()->getId());
    $stmt->bindValue(':current', $currentAccount);
    $stmt->bindValue(':bank', $bankAccount);
    $stmt->execute();

    Session::getUser()->getData('gold', false);
//    Session::getUser()->getData('bankGold', false);
}

function getApplicationVersion(): string 
{
    if (file_exists('VERSION')) {
        return trim(file_get_contents('VERSION'));
    } else {
        return '?';
    }
}

function formatGold($count)
{
    return '<img src = "resources/images/gold.png" /> ' . $count;
}

function getPlayerLocation()
{
    $location = gud('location');

    if ($location == null) {
        $location = [1, 1];
    } else {
        $location = explode(".", $location);
    }

    return $location;
}
