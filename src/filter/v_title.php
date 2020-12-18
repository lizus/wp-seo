<?php


add_filter('v_title',function ($str){
    global $wp_query;
    $seo='';
    if(defined('SEO_TITLE') && !empty(SEO_TITLE) && is_array(SEO_TITLE)) {
        if(is_home() && isset(SEO_TITLE['is_home'])) $seo=SEO_TITLE['is_home'];
        if(is_search() && isset(SEO_TITLE['is_search'])) $seo=SEO_TITLE['is_search'];
        if(is_archive()) {
            if(isset(SEO_TITLE['is_archive'])) $seo=SEO_TITLE['is_archive'];
            if(is_author() && isset(SEO_TITLE['is_author'])) $seo=SEO_TITLE['is_author'];
            if(is_date() && isset(SEO_TITLE['is_date'])) $seo=SEO_TITLE['is_date'];
            if(is_post_type_archive()) {
                if(isset(SEO_TITLE['is_post_type_archive'])) $seo=SEO_TITLE['is_post_type_archive'];
                $pt=$wp_query->get('post_type');
                if(isset(SEO_TITLE['is_'.$pt.'_archive'])) $seo=SEO_TITLE['is_'.$pt.'_archive'];
            }
            if(is_category() || is_tag() || is_tax()) {
                $obj=$wp_query->get_queried_object();
                $cid=$obj->term_id;
                $tax=$obj->taxonomy;
                if(isset(SEO_TITLE['is_term'])) $seo=SEO_TITLE['is_term'];
                if(isset(SEO_TITLE['is_'.$tax])) $seo=SEO_TITLE['is_'.$tax];
                if(isset(SEO_TITLE['is_term_'.$cid])) $seo=SEO_TITLE['is_term_'.$cid];
            }
        }
        if (is_singular()) {
            $p=$wp_query->get_queried_object();
            if(isset(SEO_TITLE['is_singular'])) $seo=SEO_TITLE['is_singular'];
            if(isset(SEO_TITLE['is_singular_'.$p->post_type])) $seo=SEO_TITLE['is_singular_'.$p->post_type];
            if(isset(SEO_TITLE['is_singular_'.$p->ID])) $seo=SEO_TITLE['is_singular_'.$p->ID];
        }
    }
    
    if (empty($seo)) $seo=$str;
    if (empty($seo) && !is_home()) $seo=wp_title('',false).' - '.get_bloginfo('name');
    if (empty($seo)) $seo=get_bloginfo('name');
    $seo=stripslashes($seo);
    $seo=\LizusSEO\seo_resolve_format($seo);
    return strip_tags($seo);
},1);