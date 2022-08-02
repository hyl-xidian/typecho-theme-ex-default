<?php

/**
 * 自定义标签页
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="col-mb-12 col-8" id="main" role="main">

    <div class="custom-link" style="margin:10px 0; padding: 0 0 0 20px;font-size:16.75px; font-weight:700;">
        <span tittle="全部博文" style="color:#223567">全部标签</a>
    </div>

    <hr>

    <?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 2000))->to($tags); ?>
    <?php while ($tags->next()) : ?>
        <a style="color: rgb(<?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>)" 
            rel="tag" class="tagslink" href="<?php $tags->permalink(); ?>" title="<?php $tags->name(); ?>" style='display: inline-block; margin: 0 5px 5px 0;'><?php $tags->name(); ?></a>
    <?php endwhile; ?>

</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>