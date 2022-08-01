基于Typecho默认主题进行了修改

增加如下特性

- 支持代码高亮

- 增加全局静态搜索

- 添加文章内容目录TOC

- 增加文章一键编辑按钮

- 增加返回顶部按钮

- 引入自托管评论系统

- 自动为文章外链添加'_blank', '_nofollow'属性

- 增加文章过期提醒

- 支持文章以Markdown格式导出

- 分类侧边栏显示文章数量

- ...

---

改造过程参见文章分类[Typecho使用](https://wiki.floatu.top/category/typecho/)


本意是想用Typecho搭建一个个人Wiki平台

> 为什么搭建个人Wiki？参见[关于Floatu's Wiki](https://wiki.floatu.top)

静态博客只能在PC上进行编译，发布

我的需求是，可以在移动设备上编辑发布

因此动态博客就成为了目标选择

WordPress太过笨重，因此选择了轻量简洁的Typecho

Typecho也有很多优秀的主题，但此站点功能较为纯粹，不需要太多花里胡哨的东西

~~并且默认主题也挺合我的审美~~

所以，我针对具体的需求，在默认主题的基础上进行了功能加强

改造思路：

- 对于本站点，在传统博客中的几个常见一级入口：归档 分类 标签中，最重要的就是「分类」---需要依托此，建立知识结构

- 快速的搜索功能很重要。因此替换掉了默认的后端数据库keywords查询的方式

- 添加其他符合个人习惯的功能
