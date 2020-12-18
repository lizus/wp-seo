<?php

add_action('wp_head',function (){
    /**
     * seo 三件套
     */
    echo '<title>'.apply_filters('v_title','').'</title>'."\n";
    echo '<meta content="'.apply_filters('v_description','').'" name="description" />'."\n";
    echo '<meta content="'.apply_filters('v_keywords','').'" name="Keywords" />'."\n";
    echo "\n";
    /**
     *https://ogp.me/
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
     */
    $og=apply_filters('v_og',[]);
    foreach ($og as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $val) {
                echo '<meta property="og:'.$key.'" content="'.$val.'">'."\n";
            }
        }else {
            echo '<meta property="og:'.$key.'" content="'.$value.'">'."\n";
        }
    }
},1);