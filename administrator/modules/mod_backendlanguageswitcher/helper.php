<?php
/**
 * @Copyright
 *
 * @package    BLS - Backend Language Switcher
 * @author     Viktor Vogel <admin@kubik-rubik.de>
 * @version    3.1.1 - 2016-01-26
 * @link       https://joomla-extensions.kubik-rubik.de/bls-backend-language-switcher
 *
 * @license    GNU/GPL
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class ModBackendLanguageSwitcherHelper
{
	public function __construct()
	{
		$backend_language = JFactory::getApplication()->input->get('backendlanguage');

		if(!empty($backend_language))
		{
			$this->setLanguage($backend_language);
		}
	}

	private function setLanguage($backend_language)
	{
		$message_string = 'MOD_BACKENDLANGUAGESWITCHER_LANGUAGECHANGED';

		if(!JLanguage::exists($backend_language))
		{
			$backend_language = 'en-GB';
			$message_string = 'MOD_BACKENDLANGUAGESWITCHER_LANGUAGENOTFOUND';
		}

		$language = JFactory::getLanguage()->getInstance($backend_language);
		$language->load('mod_backendlanguageswitcher', JPATH_ADMINISTRATOR);
		$message = $language->_($message_string);

		JFactory::getSession()->get('registry')->set('application.lang', $backend_language);

		$url = preg_replace('@[?|&]backendlanguage=(.+)$@', '', JUri::getInstance()->toString());
		JFactory::getApplication()->redirect($url, $message, 'notice');
	}

	public function createLanguageList($position)
	{
		$language_activated = JFactory::getSession()->get('registry')->get('application.lang');

		if(empty($language_activated))
		{
			$language_activated = JFactory::getLanguage()->getTag();
		}

		$languages = JLanguageHelper::createLanguageList($language_activated);
		$url = JUri::getInstance()->toString();

		$url_parameter = '?';

		if(strpos($url, '?') !== false)
		{
			$url_parameter = '&';
		}

		$url .= $url_parameter.'backendlanguage=';

		$output = '<ul class="nav pull-right"><li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">'.$language_activated.' <span class="caret"></span></a><ul class="dropdown-menu blc">';

		foreach($languages as $language)
		{
			if($language['value'] == $language_activated)
			{
				$language['text'] = '<strong>'.$language['text'].'</strong>';
			}

			$output .= '<li><a href="'.$url.$language['value'].'">'.$language['text'].'</a></li>';
		}

		$output .= '</ul></li></ul>';

		if($position == 'status')
		{
			$document = JFactory::getDocument();
			$css = 'ul.blc li a:hover{background-color: #E2E2E2; background-image: none;}';
			$document->addStyleDeclaration($css);
		}

		return $output;
	}
}