<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</div><!-- end .row -->
</div>
</div><!-- end #body -->

<footer id="footer" role="contentinfo">
    <button class="js-back-to-top back-to-top" title="回到头部">⇧</button>
    &copy; <?php echo date('Y'); ?> <a href="https://floatu.top" target="_blank">Floatu</a>.
    <?php _e('由 <a href="http://www.typecho.org">Typecho</a> 强力驱动'); ?>.
    <div style="display:none;">To see the world as it is and to love it.</div>
    <div class="beian" style="margin: 15px 0 0 0;">
        <a class="footer-badge" target="_blank" href="https://www.cloudflare.com/cdn/" style="margin-inline:5px">
            <img title="本博客使用Cloudflare CDN来加速访问" src="https://meme-repo.pages.dev/imgs/fixed/CDN-Cloudflare-orange.svg">
        </a>
        <a class="footer-badge" target="_blank" href="https://imgs.floatu.top/" style="margin-inline:5px">
            <img title="自建EasyImages图床" src="https://meme-repo.pages.dev/imgs/fixed/IHS-EasyImage-yellowgreen.svg">
        </a>
        <a class="footer-badge" target="_blank" href="https://artalk.js.org/" style="margin-inline:5px">
            <img title="使用Artalk-go搭建评论系统" src="https://meme-repo.pages.dev/imgs/fixed/comment-Artalk-blue.svg">
        </a>
    </div>
</footer><!-- end #footer -->

<script type="text/javascript">
    function rollbar(bar1, bar2, len) {
        var box = document.getElementById(bar1);
        var tocbox = document.getElementById(bar2);
            window.onscroll = function() {
                let scrollY = document.documentElement.scrollTop || document.body.scrollTop;
                let boxTop = len;
                if (scrollY > boxTop) {
                    box.style.position = "fixed";
                    box.style.top = 0;
                    tocbox.style.position = "fixed";
                    tocbox.style.top = 0;
                } else {
                    box.style.position = "absolute";
                    box.style.top = "240px";
                    box.style.left = "60%";
                    tocbox.style.position = "absolute";
                    tocbox.style.top = "240px";
                    tocbox.style.left = "0";
                }
            }
    };
    rollbar('secondary', 'toc-box', "240");
</script>
<?php $this->footer(); ?>
<script>
    $(function() {
        var $win = $(window);
        var $backToTop = $('.js-back-to-top');
        // 当用户滚动到离顶部100像素时，展示回到顶部按钮
        $win.scroll(function() {
            if ($win.scrollTop() > 100) {
                $backToTop.show();
            } else {
                $backToTop.hide();
            }
        });
        // 当用户点击按钮时，通过动画效果返回头部
        $backToTop.click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 200);
        });
    });
</script>
</body>

</html>