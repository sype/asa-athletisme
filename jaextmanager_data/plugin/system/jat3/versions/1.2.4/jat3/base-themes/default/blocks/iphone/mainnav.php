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
<div id="ja-toolbar" class="clearfix">

	<div id="ja-toolbar-top">
		<div class="nav-btns">
			<div class="links">
				<a class="toggle button btn-menu ip-button" href="#ja-iphonemenu" title="Menu">Menu</a>
			</div>
		</div>
		<div class="tools-btns">
			<div class="links">
				<?php if($this->countModules('search')) : ?>		
				<a class="toggle button btn-search ip-button" href="#ja-search" title="Search"><span>Search</span></a>
				<?php endif; ?>
				<a class="toggle button btn-login ip-button" href="#ja-login" title="Login"><span>Login</span></a>
				<?php
				//if (!($mobile = $this->mobile_device_detect())) return; 
				$handheld_view = $this->getParam('ui');
				$switch_to = $handheld_view=='desktop'?'default':'desktop';
				$text = $handheld_view=='desktop'?'Mobile Version':'Desktop Version';
				?>
				<a class="ja-tool-switchlayout toggle button btn-switchlayout" href="<?php echo JURI::base()?>?ui=<?php echo $switch_to?>" onclick="return confirm('<?php echo JText::_('Switch to standard mode confirmation')?>');" title="<?php echo JText::_($text)?>" ><span><?php echo JText::_($text)?></span></a>
			</div>
		</div>
	</div>

	<div id="ja-toolbar-main">
		<div id="ja-toolbar-wrap">

			<div id="ja-toolbar-title">
				<a class="button btn-back" href="#" id="toolbar-back" title=""></a>
				<span id="toolbar-title">&nbsp;</span>
				<a class="button btn-close" href="#" id="toolbar-close" title="">Close</a>
			</div>

			<?php if (($jamenu = $this->loadMenu('iphone'))) $jamenu->genMenu (); ?>
			
			<?php if($this->countModules('search')) : ?>
			<div id="ja-search" title="Search" class="toolbox">
				<jdoc:include type="module" name="search" />
			</div>
			<?php endif; ?>
			
			<div id="ja-login" title="Login" class="toolbox">
				<?php $this->showBlock ('iphone/login'); ?>
			</div>

		</div>
	</div>

</div>
<div id="ja-overlay">&nbsp;</div>