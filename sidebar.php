<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php if ($this->is('post')) : ?>
    <div id="toc-box" class="col-ex kit-hidden-tb" style="position:absolute; top:240px; left: 0;width:250px;">
        <?php if ($this->fields->ShowToc !== 'off') : ?>
            <?php getCatalog(); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="col-mb-12 col-offset-1 col-3 kit-hidden-tb" id="secondary" role="complementary" style="position:absolute; top:240px; left:60%;">
    <button id="search-button" class="search-form-input">搜索全部</button>
    <?php if ($this->user->hasLogin()) { ?>
            <a id="edit-post-button" href="<?php $this->options->adminUrl(); ?>write-post.php?cid=<?php echo $this->cid; ?>" title="进入后台编辑该文章" target="_blank">编辑当前文章</a>
        <?php } else { ?>
            <a id="edit-post-button" href="<?php $this->options->siteUrl(); ?>admin/login.php" title="管理员请登录" target="_blank">登录(Admin)</a>
        <?php }; ?>
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)) : ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('最新文章'); ?></h3>
            <ul class="widget-list">
                <?php \Widget\Contents\Post\Recent::alloc()
                    ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)) : ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('最近回复'); ?></h3>
            <ul class="widget-list">
                <?php \Widget\Comments\Recent::alloc()->to($comments); ?>
                <?php while ($comments->next()) : ?>
                    <li>
                        <a href="<?php $comments->permalink(); ?>"><?php $comments->author(false); ?></a>: <?php $comments->excerpt(35, '...'); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
    <?php endif; ?>




    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)) : ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('分类'); ?></h3>


            <ul class="widget-list">
                <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
                <?php while ($categorys->next()) : ?>
                    <?php if ($categorys->levels === 0) : ?>
                        <?php $children = $categorys->getAllChildren($categorys->mid); ?>
                        <?php if (empty($children)) { ?>
                            <li class="category-list-item">
                                <a class="category-list-link" href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?>
                                </a>
                                <span class="category-list-count"><?php $categorys->count(); ?></span>
                            </li>
                        <?php } else { ?>
                            <li class="category-list-item">
                                <details open>
                                    <summary>
                                        <a class="category-list-link" href="<?php $categorys->permalink(); ?>"><?php $categorys->name(); ?></a>
                                        <span class="expand_btn">Fold</span>
                                    </summary>
                                    <ul class="widget-list">
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
                                            <li class="category-list-item">
                                                <details>
                                                    <summary>
                                                        <a href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?>
                                                        </a><span class="category-list-count"> <?php echo $child['count']; ?> </span>
                                                    </summary>
                                                    <?php
                                                    $result = array_column($db->fetchAll($db->select('cid')
                                                        ->from('table.relationships')
                                                        ->where('mid = ?', $mid)), 'cid');
                                                    ?>
                                                    <?php if ($result) : ?>
                                                        <ul class="widget-list">
                                                            <?php foreach ($result as $cid) { ?>

                                                                <li class="category-list-item">
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

        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)) : ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('归档'); ?></h3>
            <ul class="widget-list">
                <?php \Widget\Contents\Post\Date::alloc('type=month&format=F Y')
                    ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)) : ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('其它'); ?></h3>
            <ul class="widget-list">
                <?php if ($this->user->hasLogin()) : ?>
                    <li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?>
                            (<?php $this->user->screenName(); ?>)</a></li>
                    <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else : ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a>
                    </li>
                <?php endif; ?>
                <li><a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章 RSS'); ?></a></li>
                <li><a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论 RSS'); ?></a></li>
                <li><a href="http://www.typecho.org">Typecho</a></li>
            </ul>
        </section>
    <?php endif; ?>

</div><!-- end #sidebar -->