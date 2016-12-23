<?php/** * @package     Joomla.Administrator * @subpackage  com_plugins * * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved. * @license     GNU General Public License version 2 or later; see LICENSE.txt */defined('_JEXEC') or die;// Include the component HTML helpers.JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');JHtml::_('bootstrap.tooltip');JHtml::_('behavior.multiselect');JHtml::_('jQuery.notify');JHtml::_('jQuery.select');JHtml::_('jQuery.scrollto');JHtml::_('formbehavior.chosen', 'select');jimport('joomla.html.htmlrender');$user = JFactory::getUser();$listOrder = $this->escape($this->state->get('list.ordering'));$listDirn = $this->escape($this->state->get('list.direction'));$canOrder = $user->authorise('core.edit.state', 'com_plugins');$saveOrder = $listOrder == 'ordering';if ($saveOrder) {    $saveOrderingUrl = 'index.php?option=com_plugins&task=plugins.saveOrderAjax&tmpl=component';    JHtml::_('sortablelist.sortable', 'pluginList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);}$doc = JFactory::getDocument();$doc->addScript(JUri::root() . 'administrator/components/com_plugins/assets/js/view_plugins_default.js');$doc->addLessStyleSheet(JUri::root() . 'administrator/components/com_plugins/assets/less/view_plugins_default.less');$input = JFactory::getApplication()->input;?><div class="view-plugins-default">    <form action="<?php echo JRoute::_('index.php?option=com_plugins&view=plugins'); ?>" method="post" name="adminForm"          id="adminForm">        <?php if (!empty($this->sidebar)) : ?>        <div id="j-sidebar-container" class="span2">            <?php echo $this->sidebar; ?>        </div>        <div id="j-main-container" class="span10">            <?php else : ?>            <div id="j-main-container">                <?php endif; ?>                <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>                <div class="clearfix"></div>                <?php if (empty($this->items)) : ?>                    <div class="alert alert-no-items">                        <?php echo JText::_('COM_PLUGINS_MSG_MANAGE_NO_PLUGINS'); ?>                    </div>                <?php else : ?>                    <table class="table table-striped" id="pluginList">                        <thead>                        <tr>                            <th width="1%" class="nowrap center hidden-phone">                                <?php echo JHtml::_('searchtools.sort', '', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>                            </th>                            <th width="1%" class="nowrap center">                                <?php echo JHtml::_('grid.checkall'); ?>                            </th>                            <th width="1%" class="nowrap center">                                <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'enabled', $listDirn, $listOrder); ?>                            </th>                            <th class="title">                                <?php echo JHtml::_('searchtools.sort', 'COM_PLUGINS_NAME_HEADING', 'name', $listDirn, $listOrder); ?>                            </th>                            <th width="10%" class="nowrap hidden-phone">                                <?php echo JHtml::_('searchtools.sort', 'COM_PLUGINS_FOLDER_HEADING', 'folder', $listDirn, $listOrder); ?>                            </th>                            <th width="10%" class="nowrap hidden-phone">                                <?php echo JHtml::_('searchtools.sort', 'COM_PLUGINS_ELEMENT_HEADING', 'element', $listDirn, $listOrder); ?>                            </th>                            <th width="5%" class="hidden-phone">                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'access', $listDirn, $listOrder); ?>                            </th>                            <th width="5%" class="hidden-phone">                                <?php echo JHtml::_('searchtools.sort', 'include menu', 'include_menu', $listDirn, $listOrder); ?>                            </th>                            <th width="5%" class="hidden-phone">                                <?php echo JHtml::_('searchtools.sort', 'exclude menu', 'exclude_menu', $listDirn, $listOrder); ?>                            </th>                            <th width="1%" class="nowrap hidden-phone">                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'extension_id', $listDirn, $listOrder); ?>                            </th>                            <th width="6%" class="nowrap hidden-phone">                                <?php echo JText::_('Action')?>                            </th>                        </tr>                        </thead>                        <tfoot>                        <tr>                            <td colspan="8">                                <?php echo $this->pagination->getListFooter(); ?>                            </td>                        </tr>                        </tfoot>                        <tbody>                        <?php foreach ($this->items as $i => $item) :                            $ordering = ($listOrder == 'ordering');                            $canEdit = $user->authorise('core.edit', 'com_plugins');                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;                            $canChange = $user->authorise('core.edit.state', 'com_plugins') && $canCheckin;                            ?>                            <tr class="row-item row<?php echo $i % 2; ?> " sortable-group-id="<?php echo $item->folder; ?>" data-extension_id="<?php echo $item->extension_id ?>">                                <td class="order nowrap center hidden-phone">                                    <?php                                    $iconClass = '';                                    if (!$canChange) {                                        $iconClass = ' inactive';                                    } elseif (!$saveOrder) {                                        $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');                                    }                                    ?>                                    <span class="sortable-handler<?php echo $iconClass; ?>">                                    <span class="icon-menu"></span>                                </span>                                    <?php if ($canChange && $saveOrder) : ?>                                        <input type="text" style="display:none" name="order[]" size="5"                                               value="<?php echo $item->ordering; ?>" class="width-20 text-area-order"/>                                    <?php endif; ?>                                </td>                                <td class="center">                                    <?php echo JHtml::_('grid.id', $i, $item->extension_id); ?>                                </td>                                <td class="center">                                    <?php echo JHtml::_('jgrid.published', $item->enabled, $i, 'plugins.', $canChange); ?>                                </td>                                <td>                                    <?php if ($item->checked_out) : ?>                                        <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'plugins.', $canCheckin); ?>                                    <?php endif; ?>                                    <?php if ($canEdit) : ?>                                        <a class="hasTooltip"                                           href="<?php echo JRoute::_('index.php?option=com_plugins&task=plugin.edit&extension_id=' . (int)$item->extension_id); ?>"                                           title="<?php echo JText::_('JACTION_EDIT'); ?>">                                            <?php echo $item->name; ?></a>                                    <?php else : ?>                                        <?php echo $item->name; ?>                                    <?php endif; ?>                                </td>                                <td class="nowrap small hidden-phone">                                    <?php echo $this->escape($item->folder); ?>                                </td>                                <td class="nowrap small hidden-phone">                                    <?php echo $this->escape($item->element); ?>                                </td>                                <td class="small hidden-phone">                                    <?php echo $this->escape($item->access_level); ?>                                </td>                                <td class="small hidden-phone include_menu">                                    <?php echo implode(',',$item->list_menu_include )?>                                </td>                                <td class="small hidden-phone exclude_menu">                                    <?php echo implode(',',$item->list_menu_exclude )?>                                </td>                                <td class="hidden-phone">                                    <?php echo (int)$item->extension_id; ?>                                </td>                                <td class="hidden-phone">                                   <button type="button" class="btn btn-micro pull-left edit-row"><span class="icon-edit"></span></button>                                   <button type="button" class="btn btn-micro pull-left delete-row"><span class="icon-delete"></span></button>                                   <button type="button" class="btn btn-micro pull-left save-row"><span class="icon-save"></span></button>                                   <button type="button" class="btn btn-micro pull-left cancel-row"><span class="icon-backward-2"></span></button>                                </td>                            </tr>                        <?php endforeach; ?>                        </tbody>                    </table>                <?php endif; ?>                <input type="hidden" name="task" value=""/>                <input type="hidden" name="boxchecked" value="0"/>                <?php echo JHtml::_('form.token'); ?>            </div>    </form></div><?php    ob_start();    ?>    <script type="text/javascript">        jQuery(document).ready(function ($) {            $('body').view_plugins_default({                view:'view-plugins-default'            });        });    </script><?php$script_content = ob_get_clean();$script_content = JUtility::remove_string_javascript($script_content);$doc->addScriptDeclaration($script_content);