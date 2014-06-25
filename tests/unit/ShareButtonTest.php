<?php

/**
 * Testing the share button.
 *
 * PHP version 5
 *
 * @category  Testing
 * @package   Facebook
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   SVN: $Id$
 * @link      http://3-magi.net/?CMSimple_XH/Facebook_XH
 */

require_once '../../cmsimple/functions.php';
require_once './classes/Presentation.php';

/**
 * Testing the share button.
 *
 * @category Testing
 * @package  Facebook
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Facebook_XH
 */
class ShareButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that the JS SDK is rendered.
     *
     * @return void
     */
    public function testRendersJsSdk()
    {
        $subject = new Facebook_Controller();
        $html = $subject->renderShareButton();
        $this->assertTag(
            array(
                'tag' => 'div',
                'id' => 'fb-root'
            ),
            $html
        );
        $this->assertTag(
            array(
                'tag' => 'script'
            ),
            $html
        );
    }

    /**
     * Tests that the JS SDK in only rendered once.
     *
     * @return void
     */
    public function testRendersJsSdkOnlyOnce()
    {
        $subject = new Facebook_Controller();
        $subject->renderShareButton();
        $this->assertNotTag(
            array(
                'tag' => 'script'
            ),
            $subject->renderShareButton()
        );
    }

    /**
     * Tests that the button is rendered.
     *
     * @return void
     *
     * @global array The configuration of the plugins.
     */
    public function testRendersButton()
    {
        global $plugin_cf;

        $plugin_cf['facebook']['share_layout'] = 'button_count';
        $subject = new Facebook_Controller();
        $this->assertTag(
            array(
                'tag' => 'div',
                'attributes' => array(
                    'class' => 'fb-share-button',
                    'data-href' => 'http://3-magi.net/',
                    'data-type' => 'button_count'
                )
            ),
            $subject->renderShareButton('http://3-magi.net/')
        );
    }
}

?>
