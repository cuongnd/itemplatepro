<?php
/**
 * @package		EasyDiscuss
 * @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 *
 * EasyDiscuss is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');

class DiscussXMLHelper
{
	private $parser 	= null;
	private $version 	= null;

	/**
	 * Creates a new instance of the Joomla parser.
	 *
	 * @since	1.0
	 * @access	public
	 */
	public function __construct( $contents = '' , $isFile = false )
	{
		$this->version 	= DiscussHelper::getJoomlaVersion();

		if( $this->version >= '3.0' )
		{
			$parser 	= JFactory::getXML( $contents , $isFile );
		}
		else
		{
			$parser 	= JFactory::getXMLParser('Simple');
			$parser->loadString( $contents );
		}

		$this->parser 	= $parser;

		return $this;
	}

	public function __call( $method, $args )
	{
		return call_user_func_array( array( $this->parser , $method ) , $args );
	}

	public function __get( $key )
	{
		return $this->parser->$key;
	}

	public function getName()
	{
		if( $this->version >= '3.0' )
		{
			$name = $this->parser->getName();

			return $name;
		}

		$name = $this->parser->document->name();
		return $name;
	}

	public function xpath( $path )
	{
		if( $this->version >= '3.0' )
		{
			$data = $this->parser->xpath( $path );
		}
		else
		{
			$element = $this->parser->document->getElementByPath( $path );
			return $element->data();
		}
	}

	/**
	 * Get's the version
	 */
	public function getVersion()
	{
		if( $this->version >= '3.0' )
		{
			$version	= $this->parser->xpath( 'version' );
			return $version[0];
		}

		$element 	= $this->parser->document->getElementByPath( 'version' );
		$version 	= $element->data();

		return $version;
	}
}
