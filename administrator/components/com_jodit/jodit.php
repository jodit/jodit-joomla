<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://xdsoft.net/jodit/
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_jodit')) {
	throw new InvalidArgumentException(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Require the helper
require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/jodit.php';
require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/autoload.php';
require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/JoditApplication.php';


// Execute the task
$controller = BaseController::getInstance('jodit');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
