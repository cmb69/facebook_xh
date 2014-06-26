<?php

/**
 * The presentation layer.
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

/**
 * The controllers.
 *
 * @category CMSimple_XH
 * @package  Facebook
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Facebook_XH
 */
class Facebook_Controller
{
    /**
     * Whether the JS SDK has already been rendered.
     *
     * @var bool
     */
    private $_isJsSdkRendered = false;

    /**
     * Dispatches according to the request.
     *
     * @return void
     *
     * @global string Whether the plugin administration is requested.
     */
    public function dispatch()
    {
        global $facebook;

        if (XH_ADM && isset($facebook) && $facebook == 'true') {
            $this->_handleAdministration();
        }
    }

    /**
     * Handles the plugin administration.
     *
     * @return void
     *
     * @global string The value of the <var>admin</var> GP parameter.
     * @global string The value of the <var>action</var> GP parameter.
     * @global string The (X)HTML fragment to insert into the contents area.
     */
    private function _handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
        case '':
            $o .= $this->_renderInfo();
            break;
        default:
            $o .= plugin_admin_common($action, $admin, 'facebook');
        }
    }

    /**
     * Renders the plugin info.
     *
     * @return string (X)HTML.
     */
    private function _renderInfo()
    {
        return '<h1>Facebook</h1>'
            . $this->_renderIcon()
            . '<p>Version: ' . FACEBOOK_VERSION . '</p>'
            . $this->_renderCopyright() . $this->_renderLicense();
    }

    /**
     * Renders the plugin icon.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     * @global array The localization of the plugins.
     */
    private function _renderIcon()
    {
        global $pth, $plugin_tx;

        return tag(
            'img src="' . $pth['folder']['plugins']
            . 'facebook/facebook.png" class="facebook_icon"'
            . ' alt="' . $plugin_tx['facebook']['alt_icon'] . '"'
        );
    }

    /**
     * Renders the copyright info.
     *
     * @return string (X)HTML.
     */
    private function _renderCopyright()
    {
        return <<<EOT
<p>Copyright &copy; 2014
    <a href="http://3-magi.net/" target="_blank">Christoph M. Becker</a>
</p>
EOT;
    }

    /**
     * Renders the license info.
     *
     * @return string (X)HTML.
     */
    private function _renderLicense()
    {
        return <<<EOT
<p class="facebook_license">This program is free software: you can
redistribute it and/or modify it under the terms of the GNU General Public
License as published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.</p>
<p class="facebook_license">This program is distributed in the hope that it
will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHAN&shy;TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.</p>
<p class="facebook_license">You should have received a copy of the GNU
General Public License along with this program. If not, see <a
href="http://www.gnu.org/licenses/" target="_blank">http://www.gnu.org/licenses/</a>.
</p>
EOT;
    }

    /**
     * Renders a facebook link.
     *
     * @param string $url A URL to link to.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     * @global array The configuration of the plugins.
     * @global array The localization of the plugins.
     */
    public function renderLink($url)
    {
        global $pth, $plugin_cf, $plugin_tx;

        $html = '<a class="facebook_link" href="' . XH_hsc($url) . '">';
        $image = $plugin_cf['facebook']['link_image'];
        $text = $plugin_tx['facebook']['link_text'];
        if ($image) {
            $html .= tag(
                'img src="' . $pth['folder']['images'] . $image
                . '" alt="' . XH_hsc($text) . '" title="' . XH_hsc($text) . '"'
            );
        } else {
            $html .= XH_hsc($text);
        }
        $html .= '</a>';
        return $html;
    }

    /**
     * Renders a like button.
     *
     * @param string $url A URL to like.
     *
     * @return string (X)HTML.
     *
     * @global array The configuration of the plugins.
     */
    public function renderLikeButton($url = '')
    {
        global $plugin_cf;

        $pcf = $plugin_cf['facebook'];
        $showFaces = $pcf['like_show_faces'] ? 'true' : 'false';
        list($width, $height) = $this->_getLikeButtonDimensions();
        return $this->_renderJsSdk()
            . '<div class="fb-like"'
            . ' data-href="' . XH_hsc($url) . '"'
            . ' data-layout="' . $pcf['like_layout'] . '"'
            . ' data-action="' . $pcf['like_action'] . '"'
            . ' data-show-faces="' . $showFaces . '"'
            . '>'
            . '</div>';
    }

    /**
     * Returns the preferred dimensions of the like button.
     *
     * @return array
     *
     * @global array The configuration of the plugins.
     *
     * @todo Actually use or remove this method.
     */
    private function _getLikeButtonDimensions()
    {
        global $plugin_cf;

        $pcf = $plugin_cf['facebook'];
        switch ($pcf['like_layout']) {
        case 'standard':
            $width = 225;
            if ($pcf['like_action'] == 'recommend') {
                $width += 40;
            }
            if ($pcf['like_show_faces']) {
                $height = 80;
            } else {
                $height = 35;
            }
            break;
        case 'box_count':
            $width = 55; $height = 65;
            break;
        case 'button_count':
            $width = 90; $height = 20;
            break;
        case 'button':
            $width = 47; $height = 20;
            break;
        }
        return array($width, $height);
    }

    /**
     * Renders a share button.
     *
     * @param string $url A URL to share.
     *
     * @return string (X)HTML.
     *
     * @global array The configuration of the plugins.
     */
    public function renderShareButton($url = '')
    {
        global $plugin_cf;

        $pcf = $plugin_cf['facebook'];
        return $this->_renderJsSdk()
            . '<div class="fb-share-button"'
            . ' data-href="' . XH_hsc($url) . '"'
            . ' data-type="' . $pcf['share_layout'] . '">'
            . '</div>';
    }

    /**
     * Renders the JS SDK.
     *
     * @return string (X)HTML.
     *
     * @global string The current language.
     * @global array  The localization of the plugins.
     */
    private function _renderJsSdk()
    {
        global $sl, $plugin_tx;

        if ($this->_isJsSdkRendered) {
            return '';
        }
        $this->_isJsSdkRendered = true;
        $language = $sl . '_' . $plugin_tx['facebook']['country_code'];
        return <<<EOT
<div id="fb-root"></div>
<script>/* <![CDATA[ */
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/$language/sdk.js#xfbml=1&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook_jssdk'));
/* ]]> */</script>
EOT;
    }
}

?>
