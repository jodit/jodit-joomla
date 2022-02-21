<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class pkg_joditInstallerScript {
    function preflight( $type, $parent ) {
        echo "Preflight remove old assets<br>";

        foreach (['css', 'js'] as $type) {
            $path = JPATH_ROOT . '/media/com_jodit/js/jodit-play/static/' . $type;
            $js = scandir($path);


            foreach ($js as $file) {
                unlink($path . '/' . $file);
            }
        }
    }
}