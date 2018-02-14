<?php
/**
 * @copyright	Copyright (c) 2018 editors. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' ); 
defined('JPATH_BASE') or die;

jimport('joomla.form.helper');

class JFormFieldPlay extends JFormField{
	static $defaultConfig = array(
		"height" => 500,
		"iframe" => true,
		"iframeBaseUrl" => '',
	);

	function getLabel() {
		return '';
	}
	function getInput() {
		$document = JFactory::getDocument();
		self::$defaultConfig['iframeBaseUrl'] = JUri::root(true);

		$config = json_decode($this->value) ?: (object)self::$defaultConfig;

		$document->addScriptDeclaration('window.JoditPlayConfig = {
		    showCode: false,
		    showEditor: true,
		    showButtonsTab: true,
		    initialConfig: ' . json_encode($config) . ',
		    setConfig: function (config) {
		        document.getElementById("' . $this->id . '").value = JSON.stringify(config);
		    },
		}');

		$document->addScript(JURI::root() . 'media/com_jodit/js/jodit/jodit.min.js');
		$document->addScript(JURI::root() . 'media/com_jodit/js/jodit-play/static/js/main.js');
		$document->addStyleSheet(JURI::root() . 'media/com_jodit/js/jodit/jodit.min.css');
		$document->addStyleSheet(JURI::root() . 'media/com_jodit/js/jodit-play/static/css/main.css');

		$document->addStyleDeclaration('.form-horizontal .controls{
			margin-left: 0 !important;
		}');

		$document->addScriptDeclaration('window.JoditPlayReady && jQuery(function () {
			window.JoditPlayReady(document.getElementById("' . $this->id . '_root"));
		})');

        return '<input type="hidden" name="' . $this->name . '" id="' . $this->id . '"/><div id="' . $this->id . '_root"></div>';
	}
}
