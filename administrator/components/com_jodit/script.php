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

//the name of the class must be the name of your component + InstallerScript
class pkg_joditInstallerScript {
    public function update($parent) {
        echo "update is working";
    }

    function preflight( $type, $parent ) {
        echo "preflight is working";

        foreach (['css', 'js'] as $type) {
            $path = JPATH_ROOT . '/media/com_jodit/js/jodit-play/static/' . $type;
            $js = scandir($path);

            foreach ($js as $file) {
                unlink($path . $file);
            }
        }
    }
}