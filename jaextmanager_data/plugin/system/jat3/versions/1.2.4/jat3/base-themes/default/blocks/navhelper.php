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
<?php
//detect view on mobile - show switch to mobile tools
$layout_switcher = $this->loadBlock('usertools/layout-switcher');
if ($layout_switcher) {
	$layout_switcher = '<li class="layout-switcher">'.$layout_switcher.'</li>';
}
?>
<div class="ja-breadcrums">
	<strong><?php echo JText::_('You are here')?></strong> <jdoc:include type="module" name="breadcrumbs" />
</div>

<ul class="ja-links">
	<?php echo $layout_switcher ?>
	<li class="top"><a href="<?php echo $this->getCurrentURL();?>#Top" title="Back to Top"><?php echo JText::_('Top') ?></a></li>
</ul>

<ul class="no-display">
	<li><a href="<?php echo $this->getCurrentURL();?>#ja-content" title="<?php echo JText::_("Skip to content");?>"><?php echo JText::_("Skip to content");?></a></li>
</ul>
