<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{
    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl',
        null,
        null,
        _t('站点 LOGO 地址'),
        _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO')
    );

    $form->addInput($logoUrl);

    $sidebarBlock = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'sidebarBlock',
        [
            'ShowRecentPosts'    => _t('显示最新文章'),
            'ShowRecentComments' => _t('显示最近回复'),
            'ShowCategory'       => _t('显示分类'),
            'ShowArchive'        => _t('显示归档'),
            'ShowOther'          => _t('显示其它杂项')
        ],
        ['ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowOther'],
        _t('侧边栏显示')
    );

    $form->addInput($sidebarBlock->multiMode());

    $outoftime = new Typecho_Widget_Helper_Form_Element_Text('outoftime', NULL,_t('15'), _t('文章过时提醒'), _t('设置文章过时提醒最大天数，默认15天，可在文章管理单独设置是否显示过期提醒'));
    $form->addInput($outoftime);

    $EnableAutoHeaderLink = new Typecho_Widget_Helper_Form_Element_Select('EnableAutoHeaderLink',
    array(
      'on' => '开启（默认）',
      "off" => '关闭'
      ),
      'on',
      '自动生成导航栏独立页面链接',
      '介绍：如果你要自定义导航栏链接部分,你可以选择关闭此项'
    );
    $form->addInput($EnableAutoHeaderLink->multiMode());
}

function themeFields($layout)
{

   // $desc = new Typecho_Widget_Helper_Form_Element_Text(
   //     'desc',
   //     NULL,
   //     NULL,
   //     'SEO描述',
   //     '用于填写文章或独立页面的SEO描述，如果不填写则没有'
   // );
   // $layout->addItem($desc);

   // $keywords = new Typecho_Widget_Helper_Form_Element_Text(
   //     'keywords',
   //     NULL,
   //     NULL,
   //     'SEO关键词',
   //     '用于填写文章或独立页面的SEO关键词，如果不填写则没有'
   // );
   // $layout->addItem($keywords);


   $showTimeWarning = new Typecho_Widget_Helper_Form_Element_Select(
       'showTimeWarning',
       array(
           'on' => '开启（默认）',
           'off' => '关闭'
       ),
       'on',
       '是否开启当前页面的文章过期警告',
       '用于单独设置当前文章的过期警告 <br /> <b>仅在文章内作用,独立页面无需改动</b> <br />'
   );
   $layout->addItem($showTimeWarning);

   // $ShowReward = new Typecho_Widget_Helper_Form_Element_Select('ShowReward',
   //     array(
   //         'off' => '关闭（默认）',
   //         'show' => '开启打赏',
   //     ),
   //     'off',
   //     '是否开启文章打赏',
   //     '介绍：开启此功能需要在主题设置中添加二维码图片'
   // );
   // $layout->addItem($ShowReward);
    $ShowToc = new Typecho_Widget_Helper_Form_Element_Select('ShowToc',
        array(
            'show' => '开启（默认）',
            'off' => '关闭',
        ),
        'show',
        '是否显示文章目录',
        '介绍：或许有的文章不需要目录功能,默认是开启的,一般不需要设置'
    );
    $layout->addItem($ShowToc);



}


function parseContent($obj){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        $obj->content = str_ireplace($options->src_add,$options->cdn_add,$obj->content);
    }
    $obj->content = preg_replace("/<a href=\"([^\"]*)\">/i", "<a href=\"\\1\" target=\"_blank\" rel=\"nofollow\">", $obj->content);
    echo trim($obj->content);
}


function createCatalog($obj) {    //为文章标题添加锚点
    global $catalog;
    global $catalog_count;
    $catalog = array();
    $catalog_count = 0;
    $obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($obj) {
        global $catalog;
        global $catalog_count;
        $catalog_count ++;
        $catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
        return '<h'.$obj[1].$obj[2].'><a name="cl-'.$catalog_count.'"></a>'.$obj[3].'</h'.$obj[1].'>';
    }, $obj);
    return $obj;
}

function getCatalog() {    //输出文章目录容器
    global $catalog;
    $index = '';
    if ($catalog) {
        $index = '<ul class="widget-list">'."\n";
        $prev_depth = '';
        $to_depth = 0;
        foreach($catalog as $catalog_item) {
            $catalog_depth = $catalog_item['depth'];
            if ($prev_depth) {
                if ($catalog_depth == $prev_depth) {
                    $index .= '</li>'."\n";
                } elseif ($catalog_depth > $prev_depth) {
                    $to_depth++;
                    $index .= '<ul class="widget-list">'."\n";
                } else {
                    $to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
                    if ($to_depth2) {
                        for ($i=0; $i<$to_depth2; $i++) {
                            $index .= '</li>'."\n".'</ul>'."\n";
                            $to_depth--;
                        }
                    }
                    $index .= '</li>';
                }
            }
            $index .= '<li><a href="#cl-'.$catalog_item['count'].'">'.$catalog_item['text'].'</a>';
            $prev_depth = $catalog_item['depth'];
        }
        for ($i=0; $i<=$to_depth; $i++) {
            $index .= '</li>'."\n".'</ul>'."\n";
        }
    $index = '<section class="widget" id="toc-container">'."\n".'<h3 class="widget-title" id="toc">目录</h3>'."\n".$index.'</section>'."\n";
    }
    echo $index;
}
function themeInit($archive) {
    if ($archive->is('single')) {
        $archive->content = createCatalog($archive->content);
    }
}
