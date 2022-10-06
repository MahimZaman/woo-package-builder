<?php

if(!function_exists('wpb_styles')){
    function wpb_styles(){
        wp_enqueue_style(
            'wpb-styles',
            WPB_DIRECTORY . '/admin/css/styles.css',
            array(),
            time()
        );

        
    }

    add_action(
        'wp_enqueue_scripts',
        'wpb_styles'
    );

    function wpb_admin_styles(){
        wp_enqueue_style(
            'wpb-admin-styles',
            WPB_DIRECTORY . '/admin/css/admin.css',
            array(),
            time()
        );


        wp_enqueue_style(
            'fontawesome-css',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css',
            array(),
            time()
        );
        
    }

    add_action(
        'admin_enqueue_scripts',
        'wpb_admin_styles'
    );
    
}