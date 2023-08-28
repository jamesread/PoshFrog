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

(@include_once '../vendor/autoload.php') or die('autoload.php not found, you probably need to run "composer update".');

$cfg = new \libAllure\ConfigFile();
$cfg->tryLoad([
    '/etc/pFrog/',
]);

\libAllure\ErrorHandler::getInstance()->beGreedy();

$db = new \libAllure\Database($cfg->getDsn(), $cfg->get('DB_USER'), $cfg->get('DB_PASS'));
\libAllure\DatabaseFactory::registerInstance($db);

use \libAllure\Session;
Session::setSessionName('pfrogUser');
Session::start();

require_once 'includes/functions.php';

\libAllure\IncludePath::addLibAllure();

require_once 'libAllure/util/shortcuts.php';

define('CFG_PASSWORD_SALT', 'asdf');

date_default_timezone_set('Europe/London');

\libAllure\AuthBackend::setBackend(new \libAllure\AuthBackendDatabase());

$breadcrumbs = array();
$breadcrumbs[] = '<a href = "index.php">index</a>';

$tpl = new \libAllure\Template('pfrog');
$tpl->assign('isLoggedIn', Session::isLoggedIn());

if (Session::isLoggedIn()) {
    $tpl->assign('user', Session::getUser());
}

$game = new \pfrog\Game();
$core = new \pfrog\Core();

