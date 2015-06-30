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

if (isset($title)) {
	echo "<h1>" . $title . "</h1>";
} else {
	Core::raiseError('Page title not set');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang = "en" lang = "en">
<head>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
<!--
function popitup(url)
{
	newwindow=window.open(url,'name','height=280,width=400');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</SCRIPT>

	<link rel = "stylesheet" href = "resources/stylesheets/style.css">
	<title><?php echo $title; ?></title>
</head>

<body class = "noBgImage">
