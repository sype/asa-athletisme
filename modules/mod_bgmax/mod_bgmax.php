<?php
/*------------------------------------------------------------------------
# mod_bgmax - bgMax
# ------------------------------------------------------------------------
# author    lomart
# copyright : Copyright (C) 2011 lomart.fr All Rights Reserved.
# @license  : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   : http://lomart.fr
# Technical Support:  Forum - http://forum.joomla.fr
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$bgmax_info = modBgMaxHelper::getBgMaxInfos($params, $module->title);

require(JModuleHelper::getLayoutPath('mod_bgmax'));