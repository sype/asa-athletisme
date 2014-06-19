<?php
defined('_JEXEC') or die;
 
class JElementModuleLayout extends JElement
{
	var $_name = 'ModuleLayout';
 
	function fetchElement($name, $value, &$node, $control_name)
	{
		$module = $node->attributes('module');
		$clientId = ($v = $node->attributes('client_id')) ? $v : 0;

		$db = JFactory::getDBO();
		$db->setQuery('SELECT template FROM #__templates_menu WHERE client_id = ' . $clientId);
		$templates = $db->loadResultArray();

		$options = array();
		$options[] = JHTML::_('select.option', '', JText::_('Default'));

		if ($module) {
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.file');

			$moduleFolder = JPath::clean(JPATH_SITE.DS.'modules'.DS.$module.DS.'tmpl');

			if (is_dir($moduleFolder) && ($files = JFolder::files($moduleFolder, '^[^_]*\.php$'))) {
				$options[] = JHTML::_('select.option', '<OPTGROUP>', JText::_('Module'));
				foreach ($files as $file) {
					$options[] = JHTML::_('select.option', JFile::stripExt($file));
				}
				$options[] = JHTML::_('select.option', '</OPTGROUP>');
			}

			if ($templates) {
				foreach ($templates as $template) {
					$templateFolder = JPath::clean(JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.$module);

					if (is_dir($templateFolder) && ($files = JFolder::files($templateFolder, '^[^_]*\.php$'))) {
						$options[] = JHTML::_('select.option', '<OPTGROUP>', JText::_('Template') . ' ' . $template);
						foreach ($files as $file) {
							$options[] = JHTML::_('select.option', JFile::stripExt($file));
						}
						$options[] = JHTML::_('select.option', '</OPTGROUP>');
					}
				}
			}
       		}

		return JHTML::_('select.genericlist', $options, $control_name.'['.$name.']', null, 'value', 'text', $value);
	}
}