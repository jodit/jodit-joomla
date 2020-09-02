<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://xdsoft.net/jodit/
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

require_once JPATH_ROOT . '/administrator/components/com_jodit/models/fields/play.php';

/**
 * editors - Jodit Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	editors.Jodit
 */
class plgEditorJodit extends JPlugin {

	/**
	 * Base path for editor files
	 */
	protected $_basePath = 'media/com_jodit/js/jodit';

	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Loads the application object
	 *
	 * @var    JApplicationCms
	 * @since  3.2
	 */
	protected $app = null;
	protected $version = '3.1.49';

	/**
	 * Initialises the Editor.
	 *
	 * @return  string  JavaScript Initialization string
	 *
	 * @since   1.5
	 */
	public function onInit() {
        $doc = jFactory::getDocument();
        $doc->addScript(JURI::root() . $this->_basePath . '/jodit.min.js?v=' . $this->version);
        $doc->addStyleSheet(JURI::root() . $this->_basePath . '/jodit.min.css?v=' . $this->version);
		return;
	}

	/**
	 * Jodit WYSIWYG Editor - get the editor content
	 *
	 * @param   string  $editor  The name of the editor
	 *
	 * @return  string
	 */
	public function onGetContent($editor) {
		return 'Jodit.instances["'.$editor.'"].value;';
	}

	/**
	 * Jodit WYSIWYG Editor - set the editor content
	 *
	 * @param   string  $editor  The name of the editor
	 * @param   string  $html    The html to place in the editor
	 *
	 * @return  string
	 */
	public function onSetContent($editor, $html) {
		return 'Jodit.instances["'.$editor.'"].value = ' . $html . ';';
	}

	/**
	 * Jodit WYSIWYG Editor - copy editor content to form field
	 *
	 * @param   string  $editor  The name of the editor
	 *
	 * @return  string
	 */
	public function onSave($editor) {
		return "document.getElementById('{$editor}').value =  Jodit.instances['".$editor."'].value;";
	}

	/**
	 * Inserts html code into the editor
	 *
	 * @param   string  $name  The name of the editor
	 *
	 * @return  void
	 */
	public function onGetInsertMethod($name) {
        return null;
	}

	/**
	 * Display the editor area.
	 *
	 * @param   string   $name     The name of the editor area.
	 * @param   string   $content  The content of the field.
	 * @param   string   $width    The width of the editor area.
	 * @param   string   $height   The height of the editor area.
	 * @param   int      $col      The number of columns for the editor area.
	 * @param   int      $row      The number of rows for the editor area.
	 * @param   boolean  $buttons  True and the editor buttons will be displayed.
	 * @param   string   $id       An optional ID for the textarea. If not supplied the name is used.
	 * @param   string   $asset    The object asset
	 * @param   object   $author   The author.
	 *
	 * @return  string
	 */
    public function onDisplay($name, $content, $width, $height, $col, $row, $buttons = true, $id = null, $asset = null, $author = null, $params = array()) {
		if (empty($id)) {
			$id = $name;
		}

		// Only add "px" to width and height if they are not given as a percentage
		if (is_numeric($width))	{
			$width .= 'px';
		}

		if (is_numeric($height)) {
			$height .= 'px';
		}

		$params = \JComponentHelper::getComponent('com_jodit')->getParams();

		/*
		 * Lets get the default template for the site application
		 */
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('template')
			->from('#__template_styles')
			->where('client_id=0 AND home=' . $db->quote('1'));

		$db->setQuery($query);

		try {
			$template = $db->loadResult();
		} catch (RuntimeException $e)	{
			JFactory::getApplication()->enqueueMessage(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');
			return;
		}

	    JFormFieldPlay::$defaultConfig['iframeBaseUrl'] = JUri::root(true);
        $options = (object)(json_decode($params->get('play')) ?: JFormFieldPlay::$defaultConfig);

        if (empty($options->iframeCSSLinks)) {
	        $options->iframeCSSLinks = [];
        }

	    $options->iframeCSSLinks[] = JURI::root() . 'media/com_jodit/css/editor.css';

	    $options->uploader = [
	    	'url' =>   ('index.php?option=com_jodit&task=filebrowser&action=fileUpload')
	    ];

	    $options->filebrowser = [
		    'ajax' => [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=fileUpload')
		    ],
		    'create' => [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=folderCreate')
		    ],
		    'getLocalFileByUrl' => [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=getlocalfilebyurl')
		    ],
		    'resize' => [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=imageresize')
		    ],
		    'crop'=> [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=imagecrop')
		    ],
		    'move'=> [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=filemove')
		    ],
		    'remove'=> [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=fileremove')
		    ],
		    'items'=> [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=files')
		    ],
		    'folder'=> [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=folders')
		    ],
		    'permissions'=> [
			    'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=permissions')
		    ],
	    ];


		$templates_path = JPATH_SITE . '/templates';

		$editor = '<textarea
            name="' . $name . '"
            id="' . $id . '"
            cols="' . $col . '"
            rows="' . $row . '"
            style="width: ' . $width . '; height: ' . $height . ';">' .
                $content .
        '</textarea>';

        $script = '<script>
            var jodit = new Jodit(document.getElementById("'.$id.'"), '.json_encode($options).');
            window.jInsertEditorText = function(text, editor) {
				jodit.selection.insertHTML(text);
			};
        </script>';

        $css = isset($options->css) ? '<style>' . $options->css . '</style>' : '';

		return $editor . $script . $this->_displayButtons($id, $buttons, $asset, $author) . $css;
	}

	/**
	 * Displays the editor buttons.
	 *
	 * @param   string  $name     The control name.
	 * @param   mixed   $buttons  [array with button objects | boolean true to display buttons]
	 * @param   string  $asset    The object asset
	 * @param   object  $author   The author.
	 *
	 * @return  string HTML
	 */
	public function _displayButtons($name, $buttons, $asset, $author)
	{
		if (is_array($buttons) || (is_bool($buttons) && $buttons))
		{
			$buttons = $this->_subject->getButtons($name, $buttons, $asset, $author);

			return JLayoutHelper::render('joomla.editors.buttons', $buttons);
		}
	}

	

	/**
	 * Get the global text filters to arbitrary text as per settings for current user groups
	 *
	 * @return  JFilterInput
	 *
	 * @since   3.6
	 */
	protected static function getGlobalFilters()
	{
		// Filter settings
		$config     = JComponentHelper::getParams('com_config');
		$user       = JFactory::getUser();
		$userGroups = JAccess::getGroupsByUser($user->get('id'));

		$filters = $config->get('filters');

		$blackListTags       = array();
		$blackListAttributes = array();

		$customListTags       = array();
		$customListAttributes = array();

		$whiteListTags       = array();
		$whiteListAttributes = array();

		$whiteList  = false;
		$blackList  = false;
		$customList = false;
		$unfiltered = false;

		// Cycle through each of the user groups the user is in.
		// Remember they are included in the public group as well.
		foreach ($userGroups as $groupId)
		{
			// May have added a group but not saved the filters.
			if (!isset($filters->$groupId))
			{
				continue;
			}

			// Each group the user is in could have different filtering properties.
			$filterData = $filters->$groupId;
			$filterType = strtoupper($filterData->filter_type);

			if ($filterType == 'NH')
			{
				// Maximum HTML filtering.
			}
			elseif ($filterType == 'NONE')
			{
				// No HTML filtering.
				$unfiltered = true;
			}
			else
			{
				// Black or white list.
				// Preprocess the tags and attributes.
				$tags           = explode(',', $filterData->filter_tags);
				$attributes     = explode(',', $filterData->filter_attributes);
				$tempTags       = array();
				$tempAttributes = array();

				foreach ($tags as $tag)
				{
					$tag = trim($tag);

					if ($tag)
					{
						$tempTags[] = $tag;
					}
				}

				foreach ($attributes as $attribute)
				{
					$attribute = trim($attribute);

					if ($attribute)
					{
						$tempAttributes[] = $attribute;
					}
				}

				// Collect the black or white list tags and attributes.
				// Each list is cummulative.
				if ($filterType == 'BL')
				{
					$blackList           = true;
					$blackListTags       = array_merge($blackListTags, $tempTags);
					$blackListAttributes = array_merge($blackListAttributes, $tempAttributes);
				}
				elseif ($filterType == 'CBL')
				{
					// Only set to true if Tags or Attributes were added
					if ($tempTags || $tempAttributes)
					{
						$customList           = true;
						$customListTags       = array_merge($customListTags, $tempTags);
						$customListAttributes = array_merge($customListAttributes, $tempAttributes);
					}
				}
				elseif ($filterType == 'WL')
				{
					$whiteList           = true;
					$whiteListTags       = array_merge($whiteListTags, $tempTags);
					$whiteListAttributes = array_merge($whiteListAttributes, $tempAttributes);
				}
			}
		}

		// Remove duplicates before processing (because the black list uses both sets of arrays).
		$blackListTags        = array_unique($blackListTags);
		$blackListAttributes  = array_unique($blackListAttributes);
		$customListTags       = array_unique($customListTags);
		$customListAttributes = array_unique($customListAttributes);
		$whiteListTags        = array_unique($whiteListTags);
		$whiteListAttributes  = array_unique($whiteListAttributes);

		// Unfiltered assumes first priority.
		if ($unfiltered)
		{
			// Dont apply filtering.
		}
		else
		{
			// Custom blacklist precedes Default blacklist
			if ($customList)
			{
				$filter = JFilterInput::getInstance(array(), array(), 1, 1);

				// Override filter's default blacklist tags and attributes
				if ($customListTags)
				{
					$filter->tagBlacklist = $customListTags;
				}

				if ($customListAttributes)
				{
					$filter->attrBlacklist = $customListAttributes;
				}
			}
			// Black lists take second precedence.
			elseif ($blackList)
			{
				// Remove the white-listed tags and attributes from the black-list.
				$blackListTags       = array_diff($blackListTags, $whiteListTags);
				$blackListAttributes = array_diff($blackListAttributes, $whiteListAttributes);

				$filter = JFilterInput::getInstance($blackListTags, $blackListAttributes, 1, 1);

				// Remove white listed tags from filter's default blacklist
				if ($whiteListTags)
				{
					$filter->tagBlacklist = array_diff($filter->tagBlacklist, $whiteListTags);
				}

				// Remove white listed attributes from filter's default blacklist
				if ($whiteListAttributes)
				{
					$filter->attrBlacklist = array_diff($filter->attrBlacklist, $whiteListAttributes);
				}
			}
			// White lists take third precedence.
			elseif ($whiteList)
			{
				// Turn off XSS auto clean
				$filter = JFilterInput::getInstance($whiteListTags, $whiteListAttributes, 0, 0, 0);
			}
			// No HTML takes last place.
			else
			{
				$filter = JFilterInput::getInstance();
			}

			return $filter;
		}
	}
}