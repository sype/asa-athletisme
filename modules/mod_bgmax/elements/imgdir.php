<?php
/*------------------------------------------------------------------------
# mod_bgmax - Custom parameter Joomla! 1.5 for bgMax
# Create directory define by parameter 'directory' if no exist
# ------------------------------------------------------------------------
# author    lomart
# copyright : Copyright (C) 2011 lomart.fr All Rights Reserved.
# @license  : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   : http://lomart.fr
# Technical Support:  Forum - http://forum.joomla.fr
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.filesystem.folder' );

class JElementImgdir extends JElement
{
    var $_name = 'Imgdir';

    function fetchElement($name, $value, &$node, $control_name)
    {
      //-- dossier
      $folder = $node->attributes('directory');
      $folder = strtr($folder,"\\",DS);


      //-- Contr�le existence folder bgmax
      if (!JFolder::exists( JPATH_ROOT . DS . $folder))  {
         if ( !JFolder::create( JPATH_ROOT . DS . $folder, 0755 ) ) {
            print_r('Error, fail to create folder: '.$folder);
            $folder = 'images/stories';  // Pour �viter erreur
         }
      }

      $filter = '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$';
      $node->addAttribute('filter', $filter);
      $node->addAttribute('directory', $folder);

      $parameter =& $this->_parent->loadElement('filelist');

      return $parameter->fetchElement($name, $value, $node, $control_name);

    }
}