<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://xdsoft.net/jodit/
 */

defined('_JEXEC') or die;

/**
 * Jodit helper.
 *
 * @package     A package name
 * @since       1.0
 */
class JoditHelper
{
    /**
     * Render submenu.
     *
     * @param   string  $vName  The name of the current view.
     *
     * @return  void.
     *
     * @since   1.0
     */
    public static function addSubmenu($vName)
    {
        JHtmlSidebar::addEntry(
            JText::_('COM_JODIT'),
            'index.php?option=com_jodit',
            $vName == 'jodit'
        );

        JHtmlSidebar::addEntry(
            JText::_('COM_JODIT_CONFIG'),
            'index.php?option=com_config&view=component&component=com_jodit',
            $vName == 'categories'
        );
    }

}