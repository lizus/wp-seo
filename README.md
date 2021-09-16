# wp-seo
集成SEO功能，通过`wp_head`输出在页面的&lt;head&gt;区域。需要在页面模板的&lt;head&gt;中添加`<?php wp_head(); >`。
定制SEO输出通过在主题包中添加常量的方式，建议新建一个`seo.php`并在`functions.php`中引入，添加三个数组常量：`SEO_TITLE`,`SEO_KEYWORDS`,`SEO_DESCRIPTION`，使用键值对来分别保存页面判断和模板字符串，页面判断可用值如下：

> `is_home` - 表示首页模板
> `is_search` - 表示搜索页
> `is_archive` - 表示归档页
> `is_date` - 表示日期归档页
> `is_author` - 表示作者归档页
> `is_post_type_archive` - 表示文章归档页
> `is_{post_type}_archive` - 表示某一文章类型归档页，具体值示例: is_post_archive
> `is_category` - 表示分类列表页
> `is_post_tag` - 表示标签列表页
> `is_tax` - 表示自定义类目列表页
> `is_{tax}` - 表示某一自定义类目列表页
> `is_term_{term_id}` - 表示某一具体类目列表页
> `is_singular` - 表示文章页
> `is_singular_{post_type}` - 表示某类型文章页
> `is_singular_{ID}` - 表示具体某文章页

## 模板可用标签
* `%site-name%` - 网站名称 &lt;通用&gt;
* `%site-description%` - 网站副标题 &lt;通用&gt;
* `%author%` - 作者 &lt;仅作者页&gt;
* `%search%` - 搜索词 &lt;仅搜索页&gt;
* `%date%` - 日期时间 &lt;仅日期归档页&gt;
* `%term-name%` - 类目名称 &lt;仅类目列表页&gt;
* `%term-description%` - 类目描述 &lt;仅类目列表页&gt;
* `%post-title%` - 文章标题 &lt;仅文章页&gt;
* `%post-keywords%` - 文章关键词，默认使用文章标签 &lt;仅文章页&gt;
* `%post-excerpt%` - 文章摘要 &lt;仅文章页&gt;
* `%post-author%` - 文章作者 &lt;仅文章页&gt;

## 常量表 - 最晚可以在主题包的functions.php中定义
* `SEO_TITLE` : &lt;array&gt; - seo用标题模板，使用键值对，键为页面判断，如：is_home,is_singular,is_term_13,is_singular_1，值为模板，下同
* `SEO_KEYWORDS` : &lt;array&gt; - seo用关键词模板
* `SEO_DESCRIPTION` : &lt;array&gt; - seo用页面描述模板

## 支持的filter
要注意的是，v_title,v_keywords,v_description这三个filter的执行通常会晚于模板标签解析。
* `add_filter('seo_resolve_format',fn($str))` - 添加模板可用标签解析，回调函数传入一个参数为需要解析的文本字符串，执行完后返回解析后的字符串即可
* `add_filter('v_title',fn($str))` - seo title
* `add_filter('v_keywords',fn($str))` - seo keywords
* `add_filter('v_description',fn($str))` - seo description
* `add_filter('v_og',fn($og))` - 添加og标签,og的传值为键值对数组
    > https://ogp.me/
        示例：
        $og=[
            'title'=>'',
            'url'=>'',
            'description'=>'',
            'type'=>'',
            'site_name'=>'',
            'image'=>'',
            'image:secure_url'=>'',
            'image:alt'=>'',
            'article:published_time'=>get_the_time('Y-m-d H:i:s'),
            'article:author'=>'',
        ];