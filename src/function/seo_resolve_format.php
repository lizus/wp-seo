<?php
namespace LizusSEO;

function seo_resolve_format($title){
    global $wp_query;
	$q=(!empty($wp_query->queried_object)) ? $wp_query->queried_object : $wp_query;
	$author='';
	$search='';
	$date='';
	$term_name='';
	$term_description='';
	$post_keywords='';
	$post_title='';
	$post_excerpt='';
	$post_author='';
	if (\is_author()) $author=$q->data->display_name;//%author%
	if (\is_search()) $search=\get_query_var('s');//%search%
	if (\is_date()) $date=\wp_title('',false);//%date%
	if (\is_category() || \is_tag() || \is_tax()){
		$q_tax=$q->taxonomy;
		$q_term_id=$q->term_id;
		if (!empty($q_tax) && !empty($q_term_id)) {
			$t=\get_term($q_term_id,$q_tax);
			if (!empty($t)) {
				$term_name=$t->name;//%term-name%
				$term_description=$t->description;//%term-description%
			}
		}
	}
	if (\is_singular()){
		$q_post_type=$q->post_type;
		$q_post_id=$q->ID;
		$post_title=\get_the_title($q_post_id);//%post-title%
        $tags=\get_the_tags($q_post_id);
        if (!empty($tags)) {
            foreach ($tags as $t){
                $post_keywords.=$t->name.',';
            }
            $post_keywords=rtrim($post_keywords,',');//%post-keywords%
        }
		if (empty($post_keywords)) $post_keywords='';//%post-keywords%
		$post_excerpt=\LizusFunction\cut_text($q->post_content,80);//%post-excerpt%
		$post_author=$q->post_author;
        $post_author=\get_userdata($post_author);
        $post_author=$post_author->display_name;//%post-author%
	}
	$title=str_replace('%site-name%',\get_bloginfo('name'),$title);
	$title=str_replace('%site-description%',\get_bloginfo('description'),$title);
	$title=str_replace('%author%',$author,$title);
	$title=str_replace('%search%',$search,$title);
	$title=str_replace('%date%',$date,$title);
	$title=str_replace('%term-name%',$term_name,$title);
	$title=str_replace('%term-description%',$term_description,$title);
	$title=str_replace('%post-title%',$post_title,$title);
	$title=str_replace('%post-keywords%',$post_keywords,$title);
	$title=str_replace('%post-excerpt%',$post_excerpt,$title);
	$title=str_replace('%post-author%',$post_author,$title);
	$title=preg_replace('/\n/',' ',$title);
	$title=preg_replace('/\s+/',' ',$title);
	$title=preg_replace('/\[\/?m\]/',' ',$title);
	return trim(\apply_filters('seo_resolve_format',$title));
    
}