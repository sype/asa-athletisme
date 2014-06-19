<?php
/*
# ------------------------------------------------------------------------
# JA T3v2 Plugin - Template framework for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - GNU/GPL V2, http://www.gnu.org/licenses/gpl2.html. For details 
# on licensing, Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/
?>
	<?php if (($jamenu = $this->loadMenu('handheld'))) $jamenu->genMenu (); ?>
	
	<?php if($this->countModules('search')) : ?>
	<div id="ja-search">
		<jdoc:include type="modules" name="search" />
	</div>
	<?php endif; ?>