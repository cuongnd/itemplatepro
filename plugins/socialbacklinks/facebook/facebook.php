<?php
/**
 * SocialBacklinks plugin for Facebook Social Network
 *
 * We developed this code with our hearts and passion.
 * We hope you found it useful, easy to understand and change.
 * Otherwise, please feel free to contact us at contact@joomunited.com
 *
 * @package 	Social Backlinks
 * @copyright 	Copyright (C) 2012 JoomUnited (http://www.joomunited.com). All rights reserved.
 * @license 	GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Facebook plugin
 */
class plgSocialbacklinksFacebook extends JPlugin
{
	/**
	 * Registers plugin in the system
	 * @return void
	 */
	public function onSBPluginRegister( )
	{
		JLoader::register( 'Facebook', JPATH_ROOT . '/plugins/socialbacklinks/facebook/facebook/facebook.php' );
		JLoader::register( 'PlgSBFacebookAdapter', JPATH_ROOT . '/plugins/socialbacklinks/facebook/facebook/adapter.php' );
		SBPlugin::register( new PlgSBFacebookAdapter( $this, array( 'title' => 'Facebook ' ) ) );
		$this->loadLanguage( );
	}

}
