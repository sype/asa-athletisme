<?php
/**
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
<!--[if IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>

<body>
<div id="main">
<div class="scroll">
	<div class="header">

		<div class="headerimg">
			<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/headerimg.jpg" alt="home loans" /></div>
		<!--<div class="title"> -->
		<!--	<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/title.jpg" alt="home loans" /></div> -->
		<div style="clear:both"></div>

	</div>
	<div class="navbar">
			<div class="nav">
				<jdoc:include type="modules" name="user3" style="table" />
			</div>
	</div>
	
	<div class="mainColumn">
			<div id="leftColumn" class="column">
				<?php if($this->countModules('left')) : ?>
					<jdoc:include type="modules" name="left" style="rounded" />
				<?php endif; ?>
			</div>
			<div class="contentColumn">
					<div id="rightColumn" class="column">
							<div class="module">
								<div>
									<div>
										<div>
											
											<div style="padding-left: 10px; padding-top: 10px; text-align:center background:#f6f6f6;">
											<jdoc:include type="modules" name="top" style="rounded" />

										</div>
									</div>
								</div>
							</div>
						</div>
							<jdoc:include type="modules" name="right" style="rounded" />
					</div>
						<div id="inner_contentColumn" class="mc">
						<div><div><div><div>
							<?php if($this->countModules('user1 or user2')) : ?>
								<table class="nopad user1user2">
									<tr class="latest" valign="top">
										<?php if($this->countModules('user1')) : ?>
											<td>
                                            		<div class="latest">
                                                    	<jdoc:include type="modules" name="user1" style="rounded" />
                                                    </div>
                                      
											</td>
										<?php endif; ?>
										<?php if($this->countModules('user1 and user2')) : ?>
											<td class="greyline">&nbsp;</td>
										<?php endif; ?>
										<?php if($this->countModules('user2')) : ?>
											<td>
                                            	<div class="latest">
                                                    <jdoc:include type="modules" name="user2" style="rounded" />
                                                </div>
											</td>
										<?php endif; ?>
									</tr>
								</table>

								<div id="maindivider"></div>
							<?php endif; ?>

							<table class="nopad">
								<tr valign="top">
									<td>
										<jdoc:include type="component" />						
										
									</td>
								</tr>
							</table>
						</div></div></div></div>

					</div>
			</div>
			<div style="clear:both"></div>
	</div>
</div>

</div><br />
<div id="footer">
	<jdoc:include type="modules" name="footer" style="xhtml"/>
	<small style="color:#666666;"><a href="http://www.blackidsolutions.com" style="color:#787878;">Joomla Template Design And Development By Black iD Solutions</a></small>
</div>
</body>
</html>