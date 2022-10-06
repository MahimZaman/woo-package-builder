<?php

if(!class_exists('Wpb_Shorcodes')){

    class Wpb_Shorcodes{
        public static function wpb_package_loop(){
            ob_start();
            
            $arg = array('post_type' => 'product');
            $wpb_query = new WP_Query($arg);


            if($wpb_query -> have_posts()):
                while($wpb_query -> have_posts()):
                    $wpb_query -> the_post(); 
                    $product = wc_get_product( get_the_ID() )
                    ?>

<div class="wpb_card">
    <h2 class="wpb-title">
        <?php the_title();?>
    </h2>
    <p class="wpb-short-des">
        <?php the_field('package-short-description');?>
    </p>
    <ul class="wpb-options">
        <?php 
            $wpb_options = explode("\n" , get_field('package_options'));

            foreach($wpb_options as $wpb_option){
                echo '<li class="wpb-item">' . $wpb_option . '</li>';
            }
        ?>
    </ul>
    <span class="wpb-price">
        <?php echo $product -> get_price() . get_woocommerce_currency_symbol() . 'TTC' ;?>
    </span>
</div>
<?php
            endwhile ;
            endif ;
            return ob_get_clean() ;
        }

        function __construct(){
            add_shortcode('wpb_package_loop_archive', array($this, 'wpb_package_loop') );
        }

        
    }

    $wpb_shorcodes = new Wpb_Shorcodes;

}