<?php

/**
 * The main "program".
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Facebook
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   SVN: $Id$
 * @link      http://3-magi.net/?CMSimple_XH/Facebook_XH
 */

/*
 * Prevent direct access.
 */
if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * The presentation layer.
 */
require_once $pth['folder']['plugin_classes'] . 'Presentation.php';

/**
 * The plugin version.
 */
define('FACEBOOK_VERSION', '@FACEBOOK_VERSION@');

/**
 * Returns the like button view.
 *
 * @param string $url A URL to like.
 *
 * @return string (X)HTML.
 *
 * @global Facebook_Controller The plugin controller.
 */
function Facebook_like($url = '')
{
    global $_Facebook_controller;

    return $_Facebook_controller->renderLikeButton(
        html_entity_decode($url, ENT_QUOTES, 'UTF-8')
    );
}

/**
 * Returns the share button view.
 *
 * @param string $url A URL to share.
 *
 * @return string (X)HTML.
 *
 * @global Facebook_Controller The plugin controller.
 */
function Facebook_share($url = '')
{
    global $_Facebook_controller;

    return $_Facebook_controller->renderShareButton(
        html_entity_decode($url, ENT_QUOTES, 'UTF-8')
    );
}

/**
 * The plugin controller.
 *
 * @var Facebook_Controller
 */
$_Facebook_controller = new Facebook_Controller();
$_Facebook_controller->dispatch();

?>
