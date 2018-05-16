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

?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10 cpanel">
    <ul  class="thumbnails">
        <li class="span2">
            <a
                id="wf-browser-link"
                class="thumbnail"
                title="Edit the Jodit Editor Configuration"
                href="index.php?option=com_config&view=component&component=com_jodit"
                target="_self"
            >
                <i class="icon-equalizer"></i>
                <h6 class="thumbnail-title text-center">
                    Editor Configuration
                </h6>
            </a>
        </li>
        <li class="span2">
            <a
               id="wf-browser-link"
               class="thumbnail"
               title="Jodit File Browser"
               href="javascript:void(0)"
               target="_blank"
               onclick='(new Jodit.modules.FileBrowser(null, <?php echo json_encode([
                       'uploader' => [
                           'url'  =>   ('index.php?option=com_jodit&task=filebrowser&action=fileUpload')
                       ],
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
                   ])?>)).open();'>
                    <i class="icon-picture"></i>
                    <h6 class="thumbnail-title text-center">File Browser</h6>
            </a>
        </li>
    </ul>
    <dl class="dl-horizontal placeholder">
        <dt class="wf-tooltip" title="Support::Documentation, Examples, Tutorials, Playground">
            Support
        </dt>
        <dd>
            <a href="https://xdsoft.net/jodit/" target="_blank">https://xdsoft.net/jodit/</a>
        </dd>
        <dt class="wf-tooltip" title="Licence::The Licence Jodit is released under">
            Licence
        </dt>
        <dd>
            <a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html" title="GNU General Public License, version 2" target="_blank">GNU General Public License, version 2</a></dd>
        <dt class="wf-tooltip" title="Version::The Editor version currently installed">
            Version
        </dt>
        <dd>
            <?php
            $component = \JComponentHelper::getComponent('com_jodit');
            $extension = \JTable::getInstance('extension');
            $extension->load($component->id);
            $manifest = new \Joomla\Registry\Registry($extension->manifest_cache);

            echo $manifest->get('version');
            ?>
        </dd>
    </dl>
</div>
