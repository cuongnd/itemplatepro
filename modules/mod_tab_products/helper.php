<?phprequire_once JPATH_ROOT . DS . 'administrator/components/com_hikashop/helpers/helper.php';/** * Created by PhpStorm. * User: cuongnd * Date: 9/8/2016 * Time: 8:57 AM */class Modtab_productsHelper{    public static $list_md5;    protected static $instances = null;    public static function getInstance()    {        if (empty(static::$instances)) {            static::$instances = new static();        }        return static::$instances;    }    public static function get_list_category_product($params,$deconstruction)    {        if($deconstruction){            $categoryHelper = hikashop_get('class.category');            $categories = $params->get('categories', '');            $list_all_category = $categories;            return $list_all_category;        }        $db = JFactory::getDbo();        $query = $db->getQuery(true);        $categoryHelper = hikashop_get('class.category');        $categories = $params->get('categories', '');        $list_all_category = $categoryHelper->getChildren($categories,true);        $list_all_category = JArrayHelper::pivot($list_all_category, 'category_id');        $list_tree_category = array();        foreach ($list_all_category as $v) {            $pt = $v->category_parent_id;            $pt = ($pt == '' || $pt == $v->id) ? 'list_root' : $pt;            $list = @$list_tree_category[$pt] ? $list_tree_category[$pt] : array();            array_push($list, $v);            $list_tree_category[$pt] = $list;        }        $get_tree_data = function ($function_call_back, $root_id = 0, &$tree_data, $list_tree_category, $level = 0) {            foreach ($list_tree_category[$root_id] as $category) {                $root_id1 = $category->category_id;                if (!in_array($category->category_id, $tree_data)) {                    $tree_data[] = $category->category_id;                }                $level1 = $level + 1;                $function_call_back($function_call_back, $root_id1, $tree_data, $list_tree_category, $level1);            }        };        $list_return_category = array();        $categories = $params->get('categories', '');        $list_all_category_id[] = 0;        foreach ($categories as $cat_id) {            $tree_data = array();            $get_tree_data($get_tree_data, $cat_id, $tree_data, $list_tree_category, 0);            $list_return_category[$cat_id]->list_sub_category_detail = $list_tree_category[$cat_id];            array_unshift($tree_data, $cat_id);            $list_all_category_id = array_merge($list_all_category_id, $tree_data);            $list_return_category[$cat_id]->list_category = $tree_data;            $list_return_category[$cat_id]->detail = $list_all_category[$cat_id];        }        $query->clear()            ->select('product.product_id,product_category.category_id,product.product_name,product.product_code')            ->from('#__hikashop_product AS product')            ->leftJoin('#__hikashop_product_category AS product_category ON product_category.product_id=product.product_id')            ->where('product_category.category_id IN(' . implode(',', $list_all_category_id) . ')')            ->where('product.product_published=1')            ->leftJoin('#__hikashop_file AS file ON file.file_ref_id=product.product_id')            ->where('file.file_type=' . $query->q('product'))            ->select('GROUP_CONCAT(file.file_path SEPARATOR  ";") AS list_image')            ->leftJoin('#__hikashop_price AS price ON price.price_product_id=product.product_id')            ->select('price.price_value')            ->group('product.product_id');        $order_by = $params->get('order_by', 'best_sale');        $sort_type = $params->get('sort_type', 'ASC');        if ($order_by == 'best_sale') {            $query->order("product_sales $sort_type");        } elseif ($order_by == 'last_product') {            $query->order("product_created $sort_type");        } elseif ($order_by == 'new_update') {            $query->order("product_modified $sort_type");        } elseif ($order_by == 'random') {            $query->order("RAND()");        } elseif ($order_by == 'hot') {            $query->order("product_total_vote $sort_type");        } elseif ($order_by == 'hit') {            $query->order("product_hit $sort_type");        }        $manufacturer = $params->get('manufacturer', '');        $md5_query = md5($query);        if (!isset(static::$list_md5[$md5_query])) {            $db->setQuery($query);            static::$list_md5[$md5_query] = $db->loadObjectList();        }        $list_product = static::$list_md5[$md5_query];        $max_product = $params->get('max_product', 20);        $max_view_small_product = $params->get('max_view_small_product', 10);        foreach ($list_product as $product) {            foreach ($list_return_category as $key => $item) {                $list_category = $item->list_category;                if (in_array($product->category_id, $list_category)) {                    $list_return_category[$key]->list = !is_array($list_return_category[$key]->list) ? array() : $list_return_category[$key]->list;                    $list_return_category[$key]->list_small_product = !is_array($list_return_category[$key]->list_small_product) ? array() : $list_return_category[$key]->list_small_product;                    if (count($list_return_category[$key]->list) < $max_product) {                        $list_return_category[$key]->list[] = $product;                    } else if (count($list_return_category[$key]->list_small_product) < $max_view_small_product) {                        $list_return_category[$key]->list_small_product[] = $product;                    }                }            }        }        return $list_return_category;    }    public  static function render_module( $module,$deconstruction=false){        if(!$deconstruction) {            $helper = self::getInstance();            $image = hikashop_get('helper.image');            $params = $module->params;            $list_category_product = $helper->get_list_category_product($params);            $currencyHelper = hikashop_get('class.currency');            $mainCurr = $currencyHelper->mainCurrency();            $style = $params->get('product_style', 'table');            $lazyload = (boolean)$params->get('lazyload', false);        }else{            $params = $module->params;            $helper = self::getInstance();            $list_category_product = $helper->get_list_category_product($params,$deconstruction);        }        ob_start();        ?>        <?php if(!$deconstruction){ ?>            <!-- Tab Navigation Menu -->            <h3 class="title"><?php echo $module->title ?></h3>            <div id="tab_product_<?php echo $module->id ?>" class="tab-product">                <ul>                    <?php foreach ($list_category_product as $category) { ?>                        <?php                        $icon_file_path=$category->detail->icon_file_path;                        ?>                        <li><a><?php echo $image->display($icon_file_path, false, "icon img-responsive", '', '', 25, 25,'',!$lazyload); ?> <?php echo $category->detail->category_name ?></a></li>                    <?php } ?>                </ul>                <!-- Content container -->                <div>                    <?php foreach ($list_category_product as $category) { ?>                        <div>                            <?php                            $list_product = $category->list;                            $file_path=$category->detail->file_path;                            $list_sub_category_detail = $category->list_sub_category_detail;                            $list_small_product = $category->list_small_product;                            ?>                            <?php if ($style == 'table') { ?>                                <?php                                $column = $params->get('total_table_column', 4);                                $list_chunk_product = array_chunk($list_product, $column);                                ?>                                <?php foreach ($list_chunk_product AS $list_product) { ?>                                    <div class="row-fluid">                                        <?php foreach ($list_product AS $product) { ?>                                            <?php                                            $list_image = $product->list_image;                                            $list_image = explode(';', $list_image);                                            $first_image = reset($list_image);                                            $link = hikashop_contentLink('product&task=show&cid=' . $product->product_id);                                            ?>                                            <div class="span<?php echo 12 / $column ?>">                                                <div class="item">                                                    <?php echo $image->display($first_image, false, "", 'class="image  img-responsive"', '', 200, 300,'',!$lazyload); ?>                                                    <div class="title"><a title="<?php echo $product->product_name ?>"                                                                          href="<?php echo $link ?>"><?php echo $product->product_name ?></a>                                                    </div>                                                    <div                                                        class="price"><?php echo $currencyHelper->format($product->price_value, $mainCurr); ?></div>                                                </div>                                            </div>                                        <?php } ?>                                    </div>                                <?php } ?>                            <?php } elseif ($style == 'slider') { ?>                                <?php                                $total_item_on_slide_screen = $params->get('total_item_on_slide_screen', 4);                                $list_chunk_product = array_chunk($list_product, $total_item_on_slide_screen);                                $total_column_sub_category=8;                                ?>                                <div class="wrapper-content ">                                    <div class="wrapper-content-left pull-left" style="width: <?php echo count($list_sub_category_detail)>$total_column_sub_category?'90%':'100%' ?> ">                                        <div class="row-fluid">                                            <div class="span12">                                                <div class="list-sub-category">                                                    <ul>                                                        <?php for($i=0;$i<count($list_sub_category_detail);$i++){ ?>                                                            <?php                                                            if($i>$total_column_sub_category-1)                                                            {                                                                break;                                                            }                                                            $sub_category=$list_sub_category_detail[$i];                                                            $icon_file_path=$sub_category->icon_file_path;                                                            ?>                                                            <li><a class="sub-category" data-category_id="<?php echo $sub_category->category_id ?>" href="javascript:void(0)"><?php echo $image->display($icon_file_path, false, "", 'class="icon  img-responsive"', '', 40,40,'',!$lazyload); ?><div class="category-name"><?php echo JString::sub_string($sub_category->category_name,20) ?></div></a></li>                                                        <?php } ?>                                                    </ul>                                                </div>                                            </div>                                        </div>                                        <div class="row-fluid">                                            <div class="span12">                                                <div class="banner">                                                    <?php echo $image->display($file_path, false, "category_image img-responsive", '', '', 980, 250,'',!$lazyload); ?>                                                </div>                                                <div class="product_slide ">                                                    <div class="control pre"><i class="icon_vg40 icon_vg40_control_left"></i></div>                                                    <div class="control next"><i class="icon_vg40 icon_vg40_control_right"></i></div>                                                    <div class="row-fluid list-product">                                                        <?php foreach ($list_product AS $product) { ?>                                                            <?php                                                            $list_image = $product->list_image;                                                            $list_image = explode(';', $list_image);                                                            $first_image = reset($list_image);                                                            //$link = hikashop_contentLink('product&task=show&cid=' . $product->product_id);                                                            $link='';                                                            ?>                                                            <div class="slide item item-<?php echo $product->product_id ?> span4">                                                                <?php echo $image->display($first_image, false, "", 'class="image  img-responsive"', '', 200,300,'',!$lazyload); ?>                                                                <div class="product-name"><a title="<?php echo $product->product_name ?>"                                                                                             href="<?php echo $link ?>"><?php echo JString::sub_string($product->product_name,30) ?> </a>                                                                </div>                                                                <div                                                                    class="price"><?php echo $currencyHelper->format($product->price_value, $mainCurr); ?></div>                                                            </div>                                                        <?php } ?>                                                    </div>                                                </div>                                            </div>                                        </div>                                        <div class="row-fluid">                                            <div class="span12">                                                <?php foreach($list_small_product as $small_product){ ?>                                                    <?php                                                    $list_image = $small_product->list_image;                                                    $list_image = explode(';', $list_image);                                                    $first_image = reset($list_image);                                                    $second_image = $list_image[1];                                                    $link = hikashop_contentLink('product&task=show&cid=' . $small_product->product_id);                                                    ?>                                                    <div id="small-product_<?php echo $module->id ?>_<?php echo $small_product->product_id ?>" class="small-product pull-left">                                                        <div id="flip_image_<?php echo $module->id ?>_<?php echo $small_product->product_id ?>" class="flip-image">                                                            <div class="front"><a title="<?php echo $small_product->product_name ?>"                                                                                  href="<?php echo $link ?>"><?php echo $image->display($first_image, false, "", 'class="image  img-responsive "', '', 200,300,'',!$lazyload); ?></a></div>                                                            <div class="back"><a title="<?php echo $small_product->product_name ?>"                                                                                 href="<?php echo $link ?>"><?php echo $image->display($second_image, false, "", 'class="image  img-responsive "', '', 200,300,'',!$lazyload); ?></a></div>                                                        </div>                                                        <div class="product-name"><a title="<?php echo $small_product->product_name ?>"                                                                                     href="<?php echo $link ?>"><?php echo JString::sub_string($small_product->product_name,25) ?> </a>                                                        </div>                                                        <div                                                            class="price"><?php echo $currencyHelper->format($small_product->price_value, $mainCurr); ?></div>                                                    </div>                                                <?php } ?>                                            </div>                                        </div>                                    </div>                                    <?php if(count($list_sub_category_detail)>$total_column_sub_category){ ?>                                        <div class="wrapper-content-right pull-left" style="width: 10%" >                                            <div class="list-sub-category vertical">                                                <ul class="vertical">                                                    <?php for($i=$total_column_sub_category;$i<count($list_sub_category_detail);$i++){ ?>                                                        <?php                                                        $sub_category=$list_sub_category_detail[$i];                                                        $icon_file_path=$sub_category->icon_file_path;                                                        ?>                                                        <li><a class="sub-category" data-category_id="<?php echo $sub_category->category_id ?>" href="javascript:void(0)"><?php echo $image->display($icon_file_path, false, "", 'class="icon  img-responsive"', '', 40,40,'',!$lazyload); ?><div class="category-name"><?php echo JString::sub_string($sub_category->category_name,20) ?></div></a></li>                                                    <?php } ?>                                                </ul>                                            </div>                                        </div>                                    <?php } ?>                                </div>                            <?php } ?>                        </div>                    <?php } ?>                </div>            </div>            <?php }else{ ?>            <!-- Tab Navigation Menu -->            <div class="wrapper-content">                <h3 class="title"><?php echo $module->title ?></h3>                <div class="row-fluid">                    <div class="span12">                        <div class="timeline-item">                            <div class="animated-background">                                <div id="tab_product_<?php echo $module->id ?>" class="tab-product ">                                    <ul>                                        <?php foreach ($list_category_product as $category) { ?>                                            <?php                                            $icon_file_path=$category->detail->icon_file_path;                                            ?>                                            <li><a ><span class="animated-background">&nbsp;</span></a></li>                                        <?php } ?>                                    </ul>                                    <!-- Content container -->                                    <div class="">                                        <?php foreach ($list_category_product as $category) { ?>                                            <div>                                                <?php if ($style == 'table') { ?>                                                    <?php                                                    $column = $params->get('total_table_column', 4);                                                    $list_chunk_product = array_chunk($list_product, $column);                                                    ?>                                                    <?php foreach ($list_chunk_product AS $list_product) { ?>                                                        <div class="row-fluid">                                                            <?php foreach ($list_product AS $product) { ?>                                                                <?php                                                                $list_image = $product->list_image;                                                                $list_image = explode(';', $list_image);                                                                $first_image = reset($list_image);                                                                $link = hikashop_contentLink('product&task=show&cid=' . $product->product_id);                                                                ?>                                                                <div class="span<?php echo 12 / $column ?>">                                                                    <div class="item">                                                                        <?php echo $image->display($first_image, false, "", 'class="icon  img-responsive"', '', 200, 300,'',!$lazyload); ?>                                                                        <div class="title"><a title="<?php echo $product->product_name ?>"                                                                                              href="<?php echo $link ?>"><?php echo $product->product_name ?></a>                                                                        </div>                                                                        <div                                                                            class="price"><?php echo $currencyHelper->format($product->price_value, $mainCurr); ?></div>                                                                    </div>                                                                </div>                                                            <?php } ?>                                                        </div>                                                    <?php } ?>                                                <?php } elseif ($style == 'slider') { ?>                                                    <?php                                                    $list_product=range ( 0,20 );                                                    $total_item_on_slide_screen = $params->get('total_item_on_slide_screen', 4);                                                    $list_chunk_product = array_chunk($list_product, $total_item_on_slide_screen);                                                    $total_column_sub_category=8;                                                    ?>                                                    <div class="wrapper-content ">                                                        <div class="wrapper-content-left pull-left" style="width: <?php echo count($list_sub_category_detail)>$total_column_sub_category?'90%':'100%' ?> ">                                                            <div class="row-fluid">                                                                <div class="span12">                                                                    <div class="list-sub-category">                                                                        <ul>                                                                            <?php for($i=0;$i<count($list_sub_category_detail);$i++){ ?>                                                                                <?php                                                                                if($i>$total_column_sub_category-1)                                                                                {                                                                                    break;                                                                                }                                                                                $sub_category=$list_sub_category_detail[$i];                                                                                $icon_file_path=$sub_category->icon_file_path;                                                                                ?>                                                                                <li><a class="sub-category" data-category_id="<?php echo $sub_category->category_id ?>" href="javascript:void(0)"><?php echo $image->display($icon_file_path, false, "", 'class="icon  img-responsive"', '', 40,40,'',!$lazyload); ?><div class="category-name"><?php echo JString::sub_string($sub_category->category_name,20) ?></div></a></li>                                                                            <?php } ?>                                                                        </ul>                                                                    </div>                                                                </div>                                                            </div>                                                            <div class="row-fluid">                                                                <div class="span12">                                                                    <div class="banner">                                                                        <div class="animated-background banner"></div>                                                                    </div>                                                                    <div class="product_slide ">                                                                        <div class="control pre"><i class="icon_vg40 icon_vg40_control_left"></i></div>                                                                        <div class="control next"><i class="icon_vg40 icon_vg40_control_right"></i></div>                                                                        <div class="row-fluid list-product">                                                                            <?php foreach ($list_product AS $product) { ?>                                                                                <?php                                                                                $list_image = $product->list_image;                                                                                $list_image = explode(';', $list_image);                                                                                $first_image = reset($list_image);                                                                                //$link = hikashop_contentLink('product&task=show&cid=' . $product->product_id);                                                                                $link='';                                                                                ?>                                                                                <div class="slide item item-<?php echo $product->product_id ?> span4">                                                                                    <?php echo $image->display($first_image, false, "", 'class="image  img-responsive"', '', 200,300,'',!$lazyload); ?>                                                                                    <div class="product-name"><a title="<?php echo $product->product_name ?>"                                                                                                                 href="<?php echo $link ?>"><?php echo JString::sub_string($product->product_name,30) ?> </a>                                                                                    </div>                                                                                    <div                                                                                        class="price"><?php echo $currencyHelper->format($product->price_value, $mainCurr); ?></div>                                                                                </div>                                                                            <?php } ?>                                                                        </div>                                                                    </div>                                                                </div>                                                            </div>                                                            <div class="row-fluid">                                                                <div class="span12">                                                                    <?php foreach($list_small_product as $small_product){ ?>                                                                        <?php                                                                        $list_image = $small_product->list_image;                                                                        $list_image = explode(';', $list_image);                                                                        $first_image = reset($list_image);                                                                        $link = hikashop_contentLink('product&task=show&cid=' . $small_product->product_id);                                                                        ?>                                                                        <div class="small-product pull-left">                                                                            <?php echo $image->display($first_image, false, "", 'class="image  img-responsive"', '', 200,300,'',!$lazyload); ?>                                                                            <div class="product-name"><a title="<?php echo $small_product->product_name ?>"                                                                                                         href="<?php echo $link ?>"><?php echo JString::sub_string($small_product->product_name,25) ?> </a>                                                                            </div>                                                                            <div                                                                                class="price"><?php echo $currencyHelper->format($small_product->price_value, $mainCurr); ?></div>                                                                        </div>                                                                    <?php } ?>                                                                </div>                                                            </div>                                                        </div>                                                        <?php if(count($list_sub_category_detail)>$total_column_sub_category){ ?>                                                            <div class="wrapper-content-right pull-left" style="width: 10%" >                                                                <div class="list-sub-category vertical">                                                                    <ul class="vertical">                                                                        <?php for($i=$total_column_sub_category;$i<count($list_sub_category_detail);$i++){ ?>                                                                            <?php                                                                            $sub_category=$list_sub_category_detail[$i];                                                                            $icon_file_path=$sub_category->icon_file_path;                                                                            ?>                                                                            <li><a class="sub-category" data-category_id="<?php echo $sub_category->category_id ?>" href="javascript:void(0)"><?php echo $image->display($icon_file_path, false, "", 'class="icon  img-responsive"', '', 40,40,'',!$lazyload); ?><div class="category-name"><?php echo JString::sub_string($sub_category->category_name,20) ?></div></a></li>                                                                        <?php } ?>                                                                    </ul>                                                                </div>                                                            </div>                                                        <?php } ?>                                                    </div>                                                <?php } ?>                                            </div>                                        <?php } ?>                                    </div>                                </div>                            </div>                        </div>                    </div>                </div>            </div>        <?php } ?>        <?php        $html=ob_get_clean();        return $html;    }}