<?php

add_filter('v_keywords',function ($str){
    global $wp_query;
    $seo='';
    if(defined('SEO_KEYWORDS') && !empty(SEO_KEYWORDS) && is_array(SEO_KEYWORDS)) {
        if(is_home() && isset(SEO_KEYWORDS['is_home'])) $seo=SEO_KEYWORDS['is_home'];
        if(is_search() && isset(SEO_KEYWORDS['is_search'])) $seo=SEO_KEYWORDS['is_search'];
        if(is_archive()) {
            if(isset(SEO_KEYWORDS['is_archive'])) $seo=SEO_KEYWORDS['is_archive'];
            if(is_author() && isset(SEO_KEYWORDS['is_author'])) $seo=SEO_KEYWORDS['is_author'];
            if(is_date() && isset(SEO_KEYWORDS['is_date'])) $seo=SEO_KEYWORDS['is_date'];
            if(is_post_type_archive()) {
                if(isset(SEO_KEYWORDS['is_post_type_archive'])) $seo=SEO_KEYWORDS['is_post_type_archive'];
                $pt=$wp_query->get('post_type');
                if(isset(SEO_KEYWORDS['is_'.$pt.'_archive'])) $seo=SEO_KEYWORDS['is_'.$pt.'_archive'];
            }
            if(is_category() || is_tag() || is_tax()) {
                $obj=$wp_query->get_queried_object();
                $cid=$obj->term_id;
                $tax=$obj->taxonomy;
                if(isset(SEO_KEYWORDS['is_term'])) $seo=SEO_KEYWORDS['is_term'];
                if(isset(SEO_KEYWORDS['is_'.$tax])) $seo=SEO_KEYWORDS['is_'.$tax];
                if(isset(SEO_KEYWORDS['is_term_'.$cid])) $seo=SEO_KEYWORDS['is_term_'.$cid];
            }
        }
        if (is_singular()) {
            $p=$wp_query->get_queried_object();
            if(isset(SEO_KEYWORDS['is_singular'])) $seo=SEO_KEYWORDS['is_singular'];
            if(isset(SEO_KEYWORDS['is_singular_'.$p->post_type])) $seo=SEO_KEYWORDS['is_singular_'.$p->post_type];
            if(isset(SEO_KEYWORDS['is_singular_'.$p->ID])) $seo=SEO_KEYWORDS['is_singular_'.$p->ID];
        }
    }
    
    if (empty($seo)) $seo=$str;
    if (empty($seo) && !is_home()) $seo=wp_title('',false).','.get_bloginfo('name');
    if (empty($seo)) $seo=get_bloginfo('name');
    $seo=stripslashes($seo);
    $seo=\LizusSEO\seo_resolve_format($seo);
    return strip_tags($seo);
},1);