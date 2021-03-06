<?php
/**
* @package		EasySocial
* @copyright	Copyright (C) 2010 - 2014 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasySocial is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined( '_JEXEC' ) or die( 'Unauthorized Access' );
?>
<dialog>
	<width>450</width>
	<height>150</height>
	<selectors type="json">
	{
		"{uninstallButton}"	: "[data-uninstall-button]",
		"{cancelButton}"	: "[data-cancel-button]"
	}
	</selectors>
	<title><?php echo JText::_( 'COM_EASYSOCIAL_APPS_CONFIRM_UNINSTALL_DIALOG_TITLE' ); ?></title>
	<content>
		<p><?php echo JText::_( 'COM_EASYSOCIAL_APPS_CONFIRM_UNINSTALL_DIALOG_CONTENT' ); ?></p>
	</content>
	<buttons>
		<button data-cancel-button type="button" class="btn btn-es btn-sm"><?php echo JText::_( 'COM_EASYSOCIAL_CANCEL_BUTTON' ); ?></button>
		<button data-uninstall-button type="button" class="btn btn-es-danger btn-sm"><?php echo JText::_( 'COM_EASYSOCIAL_UNINSTALL_APP_BUTTON' ); ?></button>
	</buttons>
</dialog>
