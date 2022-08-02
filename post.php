<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="col-mb-12 col-8" id="main" role="main">
    
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <h1 class="post-title" itemprop="name headline">
            <a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
        </h1>
        
        <ul class="post-meta">
            <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                <?php _e('作者: '); ?><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a>
            </li>
            <li><?php _e('时间: '); ?>
                <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
            </li>


            <?php if (date('Y-m-d', $this->created) !== date('Y-m-d', $this->modified)) : ?>
                <li>
                    <?php _e('更新于: '); ?><time datetime="<?php echo date(c, $this->modified); ?>" itemprop="dateModified"><?php echo date('Y-m-d', $this->modified); ?></time>
                </li>
            <?php endif; ?>


            <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
            <li itemprop="interactionCount"><a href="<?php $this->permalink() ?>#comments">评论</a>
            </li>

        </ul>
        <?php if ($this->fields->showTimeWarning !== 'off' && (time() - ($this->modified)) / 86400 >= $this->options->outoftime) : ?>

            <div style="font-weight:700;border-left: 5px solid #ff8080;margin: 15px 0 20px;border-radius: 3px;background-color: #eeefef;padding: 0.5em 1em 0.5em 0.5em">这篇文章距离最后更新已过<?php echo floor((time() - ($this->modified)) / 86400); ?>
                天，如果图片资源失效或者文章内容过时，请留言反馈，我会及时处理，感谢！
            </div>

        <?php endif; ?>

        <div class="post-content" itemprop="articleBody">
            <?php parseContent($this); ?>
        </div>
        <p itemprop="keywords" class="tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></p>
    </article>
    <div id="comments"></div>


    <ul class="post-near">
        <li>上一篇: <?php $this->thePrev('%s', '没有了'); ?></li>
        <li>下一篇: <?php $this->theNext('%s', '没有了'); ?></li>
    </ul>
</div><!-- end #main-->
<!-- CSS -->
<link href="https://npm.elemecdn.com/artalk@2.3.4/dist/Artalk.css" rel="stylesheet">

<!-- JS -->
<script src="https://npm.elemecdn.com/artalk@2.3.4/dist/Artalk.js"></script>
<!-- Artalk -->
<script>
    new Artalk({
        el: '#comments',
        pageKey: '<?php $this->permalink() ?>',
        pageTitle: '<?php $this->title() ?>',
        server: 'https://artalk.floatu.top',
        site: 'Floatu-wiki',
        placeholder: "如果对文章内容有意见，欢迎评论交流",
        noComment: "暂无评论",
        pvCount: "false",
        commentCount: "false",
        gravatar: {
            mirror: "https://cravatar.cn/avatar/",
            default: "mp"
        },
        emoticons: [
            "https://meme-repo.pages.dev/memes/emoticon.json",
            "https://meme-repo.pages.dev/memes/emoji.json",
            "https://meme-repo.pages.dev/memes/alu/alu_owo.json",
            "https://meme-repo.pages.dev/memes/huaji/huaji_owo.json",
            "https://meme-repo.pages.dev/memes/luoxiaohei/luoxiaohei_owo.json",
            "https://meme-repo.pages.dev/memes/bilibilitv/bilibilitv_artalk.json"
        ]
    })
</script>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>