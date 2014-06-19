<?php

class JElementCategory extends JElement
{
	var $_name = 'Category';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$ctrl = $control_name . '[' . $name . ']';
		$attribs = '';

		if ($v = $node->attributes('class')) {
			$attribs .= ' class="'.$v.'"';
		} else {
			$attribs .= ' class="inputbox"';
		}

		if ($node->attributes('multiple') != null) {
			$attribs .= ' multiple="multiple"';
			$ctrl .= '[]';
		}

		if ($v = $node->attributes('size')) {
			$attribs .= ' size="'.$v.'"';
		}

		$defaultOptions = array();
		foreach ($node->children() as $option) {
			$val	= $option->attributes('value');
			$text	= $option->data();
			$defaultOptions[] = JHTML::_('select.option', $val, JText::_($text));
		}

		$section = $node->attributes('section');

		if (!isset ($section)) {
			$section = $node->attributes('scope');
			if (!isset ($section)) {
				$section = 'content';
			}
		}

		$db = JFactory::getDBO();
		if ($section == 'content') {
			$query = 'SELECT c.id as value, CONCAT_WS( "/",s.title, c.title ) AS text' .
				' FROM #__categories AS c' .
				' LEFT JOIN #__sections AS s ON s.id=c.section' .
				' WHERE c.published = 1' .
				' AND s.scope = '.$db->Quote($section).
				' ORDER BY s.title, c.title';
		} else {
			$query = 'SELECT c.id as value, c.title as text' .
				' FROM #__categories AS c' .
				' WHERE c.published = 1' .
				' AND c.section = '.$db->Quote($section).
				' ORDER BY c.title';
		}
		$db->setQuery($query);
		$options = $db->loadObjectList();
		
		$options = array_merge($defaultOptions, $options);

		return JHTML::_('select.genericlist',  $options, $ctrl, trim($attribs), 'value', 'text', $value, $control_name.$name );
	}
}