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

require_once 'includes/common.php';

use \libAllure\ElementInput;
use \libAllure\ElementPassword;
use \libAllure\Session;

class FormLogin extends \libAllure\Form {
	public function __construct() {
		$this->addElement(new ElementInput('username', 'Username'));
		$this->addElement(new ElementPassword('password', 'Password'));
		$this->addDefaultButtons();
	}
}

$f = new FormLogin();

if ($f->validate()) {
	$username = $f->getElementValue('username');
	$password = $f->getElementValue('password');

	try {
		//Session::isLoggedIn();
		Session::checkCredentials($username, $password);

		$core->redirect('index.php', 'Thanks for logging in.');
	} catch (UserNotFoundException $e) {
		$f->setElementError('username', 'User not found');
	} catch (IncorrectPasswordException $e) {
		$f->setElementError('password', 'Incorrect password.');
	} catch (Exception $e) {
		$f->setGeneralError('Cannot login due to system error (' . get_class($e) . '): ' . $e->getMessage());
	}
}

$title = "login";
require_once 'includes/widgets/header.php';

$tpl->displayForm($f);

require_once ("includes/widgets/footer.php");

?>

