<?php
defined('_JEXEC') or die;
JHtml::_('jquery.framework');
JHtml::_('jquery.zozo_tab');
$doc->addScript(JUri::root() . 'media/system/js/lazy-load-xt-master/dist/jquery.lazyloadxt.js');
$doc->addLessStyleSheet(JUri::root() . 'modules/mod_tab_products/assets/less/style.less');
$doc->addStyleSheet(JUri::root() . 'media/system/js/lazy-load-xt-master/dist/jquery.lazyloadxt.fadein.css');
$doc->addLessStyleSheet(JUri::root() . 'media/system/js/slick-master/slick/slick-theme.less');
$doc->addLessStyleSheet(JUri::root() . 'modules/mod_search/assets/less/simplesearch.less');
$doc->addStyleSheet(JUri::root() . 'media/system/js/slick-master/slick/slick.css');
$doc->addScript(JUri::root() . 'media/system/js/slick-master/slick/slick.js');
$doc->addScript(JUri::root() . 'media/system/js/jquery.utility.js');
$doc->addScript(JUri::root() . 'modules/mod_search/assets/js/simplesearch.js');
require_once JPATH_ROOT . DS . 'administrator/components/com_hikashop/helpers/helper.php';
$style = $params->get('product_style', 'table');
$currencyHelper = hikashop_get('class.currency');
$mainCurr = $currencyHelper->mainCurrency();
$image=hikashop_get('helper.image');
?>

<div class="mod_search" id="mod_search_<?php echo $module->id ?>">

    <form action="index.php?option=com_hikashop&view=product" method="post">
        <div class="form-group wrapper-search">
            <div class="input-group">
                <div class="input-group-btn" >
                    <div class="btn-group">
                        <button class="btn btn-default search-by-group-product"  type="button">
                            <span data-bind="label" id="searchLabel"><?php echo JText::_('Seach by group') ?></span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu list-group-product">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                        </ul>
                    </div>
                </div>
                <input type="search" name="keyword" id="searchBy" class="form-control" />
                            <span class="input-group-btn">
                                <button id="filter" type="submit" class="btn  btn-primary search" >
                                    <?php echo JText::_('Seach') ?>
                                </button>
                            </span>
            </div>
        </div>
        <input type="hidden" name="task" value="search">
    </form>
</div>
    <?php

$js_content = '';
$doc = JFactory::getDocument();
ob_start();
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $("#mod_search_<?php echo $module->id ?>").simplesearch({
            module_id:<?php echo $module->id   ?>,
            style: "<?php echo $style ?>",
            params:<?php echo json_encode($params->toObject()) ?>
        });


    });
</script>
<?php
$js_content = ob_get_clean();
$js_content = JUtility::remove_string_javascript($js_content);
$doc->addScriptDeclaration($js_content);

?>






