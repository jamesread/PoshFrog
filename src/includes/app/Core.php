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

namespace pfrog;

/**
 * The Core class.
 *
 * Provides functions for general management, time formatting, etc.
 *
 * @package CommonClasses
 * @author  James Read <xconspirisist@gmail.com>
 * @license CCPL
 * @link    http://www.jwread.com
 */
class Core
{
    /**
     * The version number of the application currently using this class.
     */
    public $Version;

    /**
     * Constructor. Starts output buffering and sets error reporting to a
     * nice level. Will also set {$Version} of the current application for
     * caching pruposes - if a file called "VERSION" is found.
     */
    function __construct()
    {
    }

    /**
     * A simple function that encapsulates parameters into a link, which
     * will pop up a new window when clicked. WARNING: This is javascript,
     * and does not provide good assessability across browsers.
     *
     * @param string $text The text that can be clicked on.
     *
     * @param string $url  The URL of the new window.
     */
    function popup($text, $url)
    {
        echo "<a href=\"#\" onClick=\"return popitup('$url')\">$text</a>";
    }

    /**
     * Cleanly exit the application by including the footer if it hasn't
     * already been included.
     */
    function cleanExit()
    {
        if (!in_array("includes/widgets/header.php", get_included_files())) {
            exit;
        } else {
            if (!in_array("includes/widgets/footer.php", get_included_files())) {
                include_once "includes/widgets/footer.php";
                exit;
            } else {
                exit;
            }
        }
    }

    /**
     * Function to redirect users to a new page. Will send out a header
     * refresh, and a meta refresh for increased chances of sucess. Includes
     * a clickable link for accessibility reasons.
     *
     * @param string $message The message to be displayied while the redirect is
     *                        pending.
     *
     * @param string $page    The URL to be sent to.
     */
    function redirect($url, $message)
    {
        if (headers_sent()) {
            throw new Exception("Cannot use redirect at this time. <br /><br />.");
        }

        header('Refresh: 2, URL="' . $url . '"');

        $title = $message;
        include_once 'includes/widgets/header.minimal.php';

        ?>
        <fieldset>
                <legend>Redirect</legend>
        <?php echo $message; ?><br /><br />
        You will be redirected automaticly in 3 seconds. Or click <a href = "<?php echo $url; ?>">here</a>.
        </fieldset>
        <?php

        include_once 'includes/widgets/footer.php';
    }

    /**
     * Format a unix timestamp into a predefined readable format.
     *
     * @param long $timestamp The timestamp to be formatted.
     *
     * @param bool $date_only Optional value. Defines whether only the date
     *                        should be processed.
     */
    function formatTime($timestamp, $date_only = false)
    {
        $date_only = (bool)$date_only;

        if ($timestamp == '') {
            return "Never";
        }

        // TODO: replace 0 with user timezone offset, seccond
        // value with server timezone offset.
        $diff = (0 - 0 * 3600);
        $timestamp += $diff;
        $now = time();

        $date = date('jS M, Y', $timestamp);
        $today = date('jS M, Y', $now + $diff);
        $yesterday = date('jS M, Y', $now + $diff - 86400);

        if ($date == $today) {
            $date = "Today";
        } elseif ($date == $yesterday) {
            $date = "Yesterday";
        }

        if (!$date_only) {
            return $date . ' ' . date('G:i', $timestamp);
        } else {
            return $date;
        }
    }

}

