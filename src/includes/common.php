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

require_once '../vendor/autoload.php';
require_once '/etc/pfrog/config.php';

require_once 'includes/functions.php';


\libAllure\ErrorHandler::getInstance()->beGreedy();

$db = new \libAllure\Database('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
\libAllure\DatabaseFactory::registerInstance($db);


\libAllure\Session::setSessionName('pfrogUser');
\libAllure\Session::start();

define('CFG_PASSWORD_SALT', 'asdf');

date_default_timezone_set('Europe/London');

define('INC_COMMON', true);
require_once 'core.php';

define('LEVEL_ADMIN', 30);

$backend = new \libAllure\AuthBackendDatabase();
\libAllure\AuthBackend::setBackend($backend);

$breadcrumbs = array();
$breadcrumbs[] = '<a href = "index.php">index</a>';

$tpl = new \libAllure\Template('pfrog');

require_once 'includes/Game.php';

$game = new Game();
