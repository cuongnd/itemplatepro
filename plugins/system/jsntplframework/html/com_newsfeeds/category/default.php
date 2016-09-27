<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Load template framework
if (!defined('JSN_PATH_TPLFRAMEWORK')) {
	require_once JPATH_ROOT . '/plugins/system/jsntplframework/jsntplframework.defines.php';
	require_once JPATH_ROOT . '/plugins/system/jsntplframework/libraries/joomlashine/loader.php';
}
$app 		= JFactory::getApplication();
$template 	= $app->getTemplate();
$jsnUtils   = JSNTplUtils::getInstance();
if ($jsnUtils->isJoomla3()):
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

JHtml::_('behavior.caption');
JHtml::_('formbehavior.chosen', 'select');
endif;
$pageClass = $this->params->get('pageclass_sfx');
?>

<div class="com-newsfeed <?php echo $this->pageclass_sfx; ?>">
	<div class="category">
		<?php if ($this->params->def('show_page_heading', 1)) : ?>
		<h2 class="componentheading"> <?php echo $this->escape($this->params->get('page_heading')); ?> </h2>
		<?php endif; ?>
		<?php if($this->params->get('show_category_title', 1)) : ?>
		<h2 class="contentheading"> <?php echo JHtml::_('content.prepare', $this->category->title); ?> </h2>
		<?php endif; ?>
		<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
			<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
			<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
		<?php endif; ?>
		<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="contentdescription clearafter">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
			<?php endif; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<?php echo JHtml::_('content.prepare', $this->category->description); ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php echo $this->loadTemplate('items'); ?>
		<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
		<div class="cat-children">
			<h3><?php echo JText::_('JGLOBAL_SUBCATEGORIES') ; ?></h3>
			<?php echo $this->loadTemplate('children'); ?> </div>
		<?php endif; ?>
	</div>
</div>