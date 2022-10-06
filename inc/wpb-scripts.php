<?php

if(!function_exists('wpb_scripts')){
    function wpb_scripts(){
        wp_enqueue_script(
            'wpb-scripts',
            WPB_DIRECTORY . '/admin/js/scripts.js',
            array(),
            time(),
            true );

    }

    add_action(
        'wp_enqueue_scripts',
        'wpb_scripts'
    );    

    
}

function wpb_admin_scripts($hook){

    global $pagenow ;
    
    wp_register_script(
        'tailwind-addition',
        'https://cdn.tailwindcss.com',
        array(),
        '1.0',
        false                
    );


    if($pagenow == 'admin.php'){
        wp_enqueue_script('tailwind-addition');
    }

}

add_action(
'admin_enqueue_scripts',
'wpb_admin_scripts'
);