<?php

/**
 * Testing the facebook links.
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

require_once './classes/Presentation.php';

/**
 * Testing the facebook links.
 *
 * @category Testing
 * @package  Facebook
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Facebook_XH
 */
class LinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that a text link is rendered.
     *
     * @return void
     *
     * @global array The localization of the plugins.
     */
    public function testRendersTextLink()
    {
        global $plugin_tx;

        $plugin_tx['facebook']['link_text'] = 'My Facebook page';
        $subject = new Facebook_Controller();
        $this->assertTag(
            array(
                'tag' => 'a',
                'attributes' => array(
                    'class' => 'facebook_link',
                    'href' => 'https://www.facebook.com/christoph.becker.121'
                ),
                'content' => 'My Facebook page'
            ),
            $subject->renderLink('https://www.facebook.com/christoph.becker.121')
        );
    }

    /**
     * Tests that an image link is rendered.
     *
     * @return void
     *
     * @global array The paths of system files and folders.
     * @global array The configuration of the plugins.
     * @global array The localization of the plugins.
     */
    public function testRendersImageLink()
    {
        global $pth, $plugin_cf, $plugin_tx;

        $pth['folder']['images'] = './images/';
        $plugin_cf['facebook']['link_image'] = 'fb.png';
        $plugin_tx['facebook']['link_text'] = 'My Facebook page';
        $subject = new Facebook_Controller();
        $this->assertTag(
            array(
                'tag' => 'a',
                'attributes' => array(
                    'class' => 'facebook_link',
                    'href' => 'https://www.facebook.com/christoph.becker.121'
                ),
                'child' => array(
                    'tag' => 'img',
                    'attributes' => array(
                        'src' => './images/fb.png',
                        'alt' => 'My Facebook page',
                        'title' => 'My Facebook page'
                    )
                )
            ),
            $subject->renderLink('https://www.facebook.com/christoph.becker.121')
        );
    }
}

?>
