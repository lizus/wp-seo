<?php


add_filter('v_description',function ($str){
    global $wp_query;
    $seo='';
    if(defined('SEO_DESCRIPTION') && !empty(SEO_DESCRIPTION) && is_array(SEO_DESCRIPTION)) {
        if(is_home() && isset(SEO_DESCRIPTION['is_home'])) $seo=SEO_DESCRIPTION['is_home'];
        if(is_search() && isset(SEO_DESCRIPTION['is_search'])) $seo=SEO_DESCRIPTION['is_search'];
        if(is_archive()) {
            if(isset(SEO_DESCRIPTION['is_archive'])) $seo=SEO_DESCRIPTION['is_archive'];
            if(is_author() && isset(SEO_DESCRIPTION['is_author'])) $seo=SEO_DESCRIPTION['is_author'];
            if(is_date() && isset(SEO_DESCRIPTION['is_date'])) $seo=SEO_DESCRIPTION['is_date'];
            if(is_post_type_archive()) {
                if(isset(SEO_DESCRIPTION['is_post_type_archive'])) $seo=SEO_DESCRIPTION['is_post_type_archive'];
                $pt=$wp_query->get('post_type');
                if(isset(SEO_DESCRIPTION['is_'.$pt.'_archive'])) $seo=SEO_DESCRIPTION['is_'.$pt.'_archive'];
            }
            if(is_category() || is_tag() || is_tax()) {
                $obj=$wp_query->get_queried_object();
                $cid=$obj->term_id;
                $tax=$obj->taxonomy;
                if(isset(SEO_DESCRIPTION['is_term'])) $seo=SEO_DESCRIPTION['is_term'];
                if(isset(SEO_DESCRIPTION['is_'.$tax])) $seo=SEO_DESCRIPTION['is_'.$tax];
                if(isset(SEO_DESCRIPTION['is_term_'.$cid])) $seo=SEO_DESCRIPTION['is_term_'.$cid];
            }
        }
        if (is_singular()) {
            $p=$wp_query->get_queried_object();
            if(isset(SEO_DESCRIPTION['is_singular'])) $seo=SEO_DESCRIPTION['is_singular'];
            if(isset(SEO_DESCRIPTION['is_singular_'.$p->post_type])) $seo=SEO_DESCRIPTION['is_singular_'.$p->post_type];
            if(isset(SEO_DESCRIPTION['is_singular_'.$p->ID])) $seo=SEO_DESCRIPTION['is_singular_'.$p->ID];
        }
    }
    
    if (empty($seo)) $seo=$str;
    if (empty($seo) && !is_home()) $seo=wp_title('',false);
    if (empty($seo)) $seo=get_bloginfo('name');
    $seo=stripslashes($seo);
    $seo=\LizusSEO\seo_resolve_format($seo);
    return strip_tags($seo);
},1);