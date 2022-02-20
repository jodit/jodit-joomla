<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://xdsoft.net/jodit/
 */
defined( '_JEXEC' ) or die( 'Restricted access' ); 
defined('JPATH_BASE') or die;

jimport('joomla.form.helper');

class JFormFieldPlay extends JFormField{
    protected function _basePath() {
        $params = \JComponentHelper::getComponent('com_jodit')->getParams();
        $folder = $params->get('jodit-pro') === '1' ? 'jodit-pro/jodit.fat' : 'jodit/jodit.min';
        return 'media/com_jodit/js/' . $folder;
    }

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

		$document->addScriptDeclaration('window.JoditConfig = ' . json_encode($config) . ';');
		$document->addScriptDeclaration('window.JoditPlayConfig = {
		    showCode: false,
		    showEditor: true,
		    showButtonsTab: true,
		    historyAPI: false,
		    dataURL: "' . JURI::root() . 'media/com_jodit/js/jodit-play/",
		    initialCSS: ' . json_encode(isset($config->css) ? $config->css : "") . ',
		    initialConfig: ' . json_encode($config) . ',
		    setCSS: function (css) {
		        window.JoditConfig.css = css;
		        document.getElementById("' . $this->id . '").value = JSON.stringify(window.JoditConfig);
		    },
		    setConfig: function (config) {
		        var css = window.JoditConfig.css;
		        window.JoditConfig = jQuery.extend(true, {}, config);
		        window.JoditConfig.css = css;
		      
		        document.getElementById("' . $this->id . '").value = JSON.stringify(window.JoditConfig);
		    },
		};');

		$playversion = json_decode(file_get_contents(JPATH_ROOT . '/media/com_jodit/js/jodit-play/package.json'))->version;

		$document->addScript(JURI::root() . $this->_basePath() . '.js');

        $js = (array_filter(scandir(JPATH_ROOT . '/media/com_jodit/js/jodit-play/static/js'), function ($path) {
            return preg_match('/chunk\.js$/', $path) or preg_match('/runtime-main.*\.js$/', $path);
        }));
        foreach ($js as $file) {
            $document->addScript(JURI::root() . 'media/com_jodit/js/jodit-play/static/js/' . $file . '?v=' . $playversion);
        }

		$document->addStyleSheet(JURI::root()  . $this->_basePath() . '.css');

        $css = (array_filter(scandir(JPATH_ROOT . '/media/com_jodit/js/jodit-play/static/css'), function ($path) {
            return preg_match('/chunk\.css$/', $path);
        }));
        foreach ($css as $file) {
            $document->addStyleSheet(JURI::root() . 'media/com_jodit/js/jodit-play/static/css/' . $file);
        }

		$document->addStyleDeclaration('.form-horizontal .controls{
			margin-left: 0 !important;
		}');

		$document->addScriptDeclaration('window.JoditPlayReady && jQuery(function () {
			window.JoditPlayReady(document.getElementById("' . $this->id . '_root"));
		})');

        return '<input type="hidden" name="' . $this->name . '" id="' . $this->id . '"/><div id="' . $this->id . '_root"></div>';
	}
}
