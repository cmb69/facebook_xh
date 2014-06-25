<?php

/**
 * Testing the like button.
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
 * Testing the like button.
 *
 * @category Testing
 * @package  Facebook
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Facebook_XH
 */
class LikeButtonTest extends PHPUnit_Framework_TestCase
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
     * Tests the button.
     *
     * @param array  $config Configuration options.
     * @param string $url    A URL to like.
     * @param string $src    The value of the src attribute.
     *
     * @return void
     *
     * @dataProvider testData
     */
    public function testButton($config, $url, $src)
    {
        global $plugin_cf;

        $plugin_cf['facebook'] = $config;
        $showFaces = $config['like_show_faces'] ? 'true' : 'false';
        $subject = new Facebook_Controller();
        $this->assertTag(
            array(
                'tag' => 'div',
                'attributes' => array(
                    'class' => 'fb-like',
                    'data-href' => $url,
                    'data-layout' => $config['like_layout'],
                    'data-action' => $config['like_action'],
                    'data-show-faces' => $showFaces
                )
            ),
            $subject->renderLikeButton($url)
        );
    }

    /**
     * Provides data for testing the button.
     *
     * @return array
     */
    public function testData()
    {
        return array(
            array(
                array(
                    'like_action' => 'like',
                    'like_layout' => 'standard',
                    'like_show_faces' => ''
                ),
                'http://www.google.de/',
                'https://www.facebook.com/plugins/like.php'
                . '?href=http%3A%2F%2Fwww.google.de%2F&width=225&layout=standard'
                . '&action=like&show_faces=false&height=35'
            ),
            array(
                array(
                    'like_action' => 'recommend',
                    'like_layout' => 'standard',
                    'like_show_faces' => 'true'
                ),
                'http://www.google.de/',
                'https://www.facebook.com/plugins/like.php'
                . '?href=http%3A%2F%2Fwww.google.de%2F&width=265&layout=standard'
                . '&action=recommend&show_faces=true&height=80'
            ),
            array(
                array(
                    'like_action' => 'like',
                    'like_layout' => 'box_count',
                    'like_show_faces' => ''
                ),
                'http://www.google.de/',
                'https://www.facebook.com/plugins/like.php'
                . '?href=http%3A%2F%2Fwww.google.de%2F&width=55&layout=box_count'
                . '&action=like&show_faces=false&height=65'
            ),
            array(
                array(
                    'like_action' => 'like',
                    'like_layout' => 'button_count',
                    'like_show_faces' => ''
                ),
                'http://www.google.de/',
                'https://www.facebook.com/plugins/like.php'
                . '?href=http%3A%2F%2Fwww.google.de%2F&width=90&layout=button_count'
                . '&action=like&show_faces=false&height=20'
            ),
            array(
                array(
                    'like_action' => 'like',
                    'like_layout' => 'button',
                    'like_show_faces' => ''
                ),
                'http://www.google.de/',
                'https://www.facebook.com/plugins/like.php'
                . '?href=http%3A%2F%2Fwww.google.de%2F&width=47&layout=button'
                . '&action=like&show_faces=false&height=20'
            )
        );
    }
}

?>
