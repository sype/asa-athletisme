<?php
/**
 * @version		$Id: readmore.php 10709 2008-08-21 09:58:52Z eddieajau $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Editor Readmore buton
 *
 * @package Editors-xtd
 * @since 1.5
 */
class plgSystemJATypo extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param 	object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */
	function plgSystemJATypo(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}
	function allowUseTypo()
	{
		global $mainframe;
		$option = JRequest::getVar("option","");
		$format = JRequest::getVar("format","");
		if( $option == "com_content" && $format == "feed"){
			return false;
		}
		return true;
	}
	/**
	 * readmore button
	 * @return array A two element array of ( imageName, textToInsert )
	 */
	function onAfterRoute()
	{
		global $mainframe;
		if( $this->allowUseTypo() ){
			$doc 		=& JFactory::getDocument();
			
			$base_url = JURI::base();
			if($mainframe->isAdmin()) {
				$base_url = dirname ($base_url);
				JHTML::_('behavior.mootools');
				$doc->addScript($base_url.'/plugins/system/jatypo/assets/script.js');
				$doc->addStylesheet($base_url.'/plugins/system/jatypo/assets/style.css');		
			}
			$doc->addStylesheet($base_url."/plugins/system/jatypo/typo/typo.css");
		}
	}

	function onAfterRender () {
		global $mainframe;
		if( $this->allowUseTypo() ){
			$jatypo = JRequest::getCmd ('jatypo');
			if (!$mainframe->isAdmin() && !$jatypo) return;

			$tmpl = dirname (__FILE__).DS.'jatypo'.DS.'tmpl'.DS.'default.php';		
			$html = $this->loadTemplate ($tmpl);
			//$html = file_get_contents ($tmpl);
			//if (preg_match ('/<body[^>]*>(.*)<\/body>/s', $html, $matches)) $html = $matches[1];
			
			$buffer = JResponse::getBody();
			if($mainframe->isAdmin()) {
				if (preg_match ('/id=\"editor-xtd-buttons\"/', $buffer)) {
					//exist editor
					//$html = "<div id=\"jatypo-wrap\">$html</div>";
					$buffer = preg_replace ('/<\/body>/', "\n$html\n</body>", $buffer);
					JResponse::setBody ($buffer);
				}
				return;
			}
			
			//replace body by the sample
			$buffer = preg_replace ('/<body([^>]*)>.*<\/body>/s', "<body\\1>$html</body>", $buffer);
			JResponse::setBody ($buffer);
		}
	}
	
	function loadTemplate ($template) {
		if (!is_file ($template)) return '';
		$buffer = ob_get_clean();
		ob_start();
		include ($template);
		$content = ob_get_clean();
		ob_start();
		echo $buffer;
		return $content;
	}
}