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
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

/**
 * Jodit view.
 *
 * @package  jodit
 * @since    1.0
 */
class JoditViewJodit extends HtmlView
{
	/**
	 * Jodit helper
	 *
	 * @var    JoditHelper
	 * @since  1.0
	 */
	protected $helper;

	/**
	 * The sidebar to show
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $sidebar = '';

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @see     fetch()
	 * @since   1.0
	 */
	public function display($tpl = null)
	{
		// Show the toolbar
		$this->toolbar();

		// Show the sidebar
		$this->helper = new JoditHelper;
		$this->helper->addSubmenu('jodit');
		$this->sidebar = JHtmlSidebar::render();

		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . 'media/com_jodit/js/jodit/jodit.min.js');
		$document->addStyleSheet(JURI::root() . 'media/com_jodit/js/jodit/jodit.min.css');
		$document->addStyleSheet(JURI::root() . 'media/com_jodit/css/admin.css');
		// Display it all
		return parent::display($tpl);
	}

	/**
	 * Displays a toolbar for a specific page.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	private function toolbar()
	{
		JToolBarHelper::title(Text::_('COM_JODIT'), '');

		// Options button.
		if (Factory::getUser()->authorise('core.admin', 'com_jodit'))
		{
			JToolBarHelper::preferences('com_jodit');
		}
	}
}
