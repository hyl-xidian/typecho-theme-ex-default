<?php

/**
 * 自定义分类页
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="col-mb-12 col-8" id="main" role="main">

    <div class="custom-link" style="margin:10px 0; padding: 0 0 0 20px;font-size:16.75px; font-weight:700;color:#223567;">
        <a href="<?php $this->options->siteUrl(); ?>posts-tag.html" title="全部标签">标签页</a><br>
        <!--<a href="https://wiki.floatu.top/posts" tittle="全部博文">全部文章</a>-->
       
    </div>

    <hr>
    
    <div class="category-lists">
        <ul class="category-list" style="margin: 10px 0;">
            <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
            <?php while ($categorys->next()) : ?>
                <?php if ($categorys->levels === 0) : ?>
                    <?php $children = $categorys->getAllChildren($categorys->mid); ?>
                    <?php if (empty($children)) { ?>
                        <li class="category-list-item" style="font-size:16.75px; font-weight:700;margin: 10px 0;color:#223567">
                            <span class="category-list-link" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?>
                            </span>
                            <span class="category-list-count"><?php $categorys->count(); ?></span>
                        </li>
                    <?php } else { ?>
                        <li class="category-list-item" style="margin: 10px 0;">
                            <details open>
                                <summary>
                                    <span class="category-list-link" style="font-size:16.75px;font-weight:700;color:#223567"><?php $categorys->name(); ?></span>
                                    <span class="expand_btn">Fold</span>
                                </summary>
                                <ul class="category-list" style="margin: 10px 0;">
                                    <?php $db = Typecho_Db::get(); ?>
                                    <?php
                                    $res = array_column($db->fetchAll($db->select('cid')
                                        ->from('table.relationships')
                                        ->where('mid = ?', $categorys->mid)), 'cid');
                                    ?>
                                    <?php if ($res) : ?>
                                        <?php foreach ($res as $tcid) { ?>
                                            <li class="category-list-item" style="font-size:14px; font-weight:500;margin: 7px 0;">
                                                <?php $list_p = Typecho_Widget::widget('Widget_Archive@' . $tcid, 'pageSize=1&type=post', 'cid=' . $tcid); ?>
                                                <a href="<?php echo $list_p->permalink(); ?>" title="<?php echo $list_p->title(); ?>"><?php echo $list_p->title(); ?></a>
                                            </li>
                                        <?php
                                        } ?>
                                    <?php endif; ?>
                                    <?php foreach ($children as $mid) { ?>
                                        <?php
                                        $child = $categorys->getCategory($mid);
                                        echo ($this->is('category', $mid)); ?>
                                        <li class="category-list-item" style="font-size:14px; font-weight:500;margin: 7px 0;">
                                            <details open>
                                                <summary>
                                                    <span class="category-list-link" title="<?php echo $child['name']; ?>" style="color:#223567"><?php echo $child['name']; ?>
                                                    </span><span class="category-list-count"> <?php echo $child['count']; ?></span>
                                                </summary>
                                                <?php
                                                $result = array_column($db->fetchAll($db->select('cid')
                                                    ->from('table.relationships')
                                                    ->where('mid = ?', $mid)), 'cid');
                                                ?>
                                                <?php if ($result) : ?>
                                                    <ul class="category-list-child">
                                                        <?php foreach ($result as $cid) { ?>

                                                            <li class="category-list-item" style="margin:7px 0;">
                                                                <?php $ji = Typecho_Widget::widget('Widget_Archive@' . $cid, 'pageSize=1&type=post', 'cid=' . $cid); ?>
                                                                <a href="<?php echo $ji->permalink(); ?>" title="<?php echo $ji->title(); ?>"><?php echo $ji->title(); ?></a>
                                                            </li>
                                                        <?php
                                                        } ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </details>
                                        </li>
                                    <?php
                                    } ?>
                                </ul>
                            </details>
                        </li>
                    <?php } ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    </div>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>