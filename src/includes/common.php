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

require_once 'libAllure/ErrorHandler.php';
require_once 'libAllure/Exceptions.php';
require_once 'libAllure/AuthBackend.php';
require_once 'libAllure/User.php';
require_once 'libAllure/Session.php';
require_once 'libAllure/Logger.php';
require_once 'libAllure/Form.php';
require_once 'libAllure/Inflector.php';
require_once 'includes/functions.php';

class SimpleFatalError {}
class PermissionException extends SimpleFatalError {}
class PrivilegeException extends PermissionException {}

$db = new \libAllure\Database('mysql:host=localhost;dbname=pfrog', 'root', '');
\libAllure\DatabaseFactory::registerInstance($db);


\libAllure\Session::setSessionName('pfrogUser');
\libAllure\Session::start();

define ('CFG_PASSWORD_SALT', 'asdf');

date_default_timezone_set('Europe/London');

$eh = \libAllure\ErrorHandler::getInstance();
$eh->beGreedy();

define('INC_COMMON', true);
require_once 'core.php';

requirE_once 'libAllure/Database.php';

define('LEVEL_ADMIN', 30);

if (\libAllure\Session::isLoggedIn()) {
	$user = \libAllure\Session::getUser();
}

require_once 'libAllure/AuthBackendDatabase.php';

$backend = new \libAllure\AuthBackendDatabase();
\libAllure\AuthBackend::setBackend($backend);

$breadcrumbs = array();
$breadcrumbs[] = '<a href = "index.php">index</a>';

require_once 'libAllure/Template.php';

$tpl = new \libAllure\Template('pfrog');

require_once 'includes/Game.php';

$game = new Game();

?>
