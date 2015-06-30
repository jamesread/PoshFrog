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

require_once 'jwrCommonsPhp/ErrorHandler.php';
require_once 'jwrCommonsPhp/Exceptions.php';
require_once 'jwrCommonsPhp/AuthBackend.php';
require_once 'jwrCommonsPhp/User.php';
require_once 'jwrCommonsPhp/Session.php';
require_once 'jwrCommonsPhp/Logger.php';
require_once 'jwrCommonsPhp/Form.php';
require_once 'jwrCommonsPhp/Inflector.php';
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

requirE_once 'jwrCommonsPhp/Database.php';

define('LEVEL_ADMIN', 30);

class pFrogUser extends \libAllure\User {
	function isLoggedIn() {
		return $this->getAuth();
    }

	function isAdmin() {
		return $this->getData('level') > LEVEL_ADMIN;
	}

	function checkAdmin() {
		if (!$this->isAdmin()) {
			Core::raiseError('You are trying to access a restricted area.\n\n');
		}
	}

	function getTurns() {
		return getTurns($this->username);
	}

	function inAdminMode() {
		if (!$this->isAdmin()) {
			return false;
		}

		if ($this->getData('admin_mode')) {
			return true;
		} else {
			return false;
		}
	}
}

//
// misc
//

if (\libAllure\Session::isLoggedIn()) {
	$user = \libAllure\Session::getUser();
}

require_once 'jwrCommonsPhp/AuthBackendDatabase.php';

\libAllure\AuthBackend::setBackend(new \libAllure\AuthBackendDatabase());

$breadcrumbs = array();
$breadcrumbs[] = '<a href = "index.php">index</a>';

require_once 'libAllure/Template.php';

$tpl = new \libAllure\Template('pfrog');

?>
