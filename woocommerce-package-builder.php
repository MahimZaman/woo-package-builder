<?php

/**
 * Plugin Name:       Woocommerce Package Builder
 * Plugin URI:        https://example.com
 * Description:       Build packages as woocommerce product.
 * Version:           1.0
 * Author:            Stuck In Codes
 * Author URI:        https://www.mahimzaman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woocommerce-package-builder
 * Domain Path:       /lang
 */

if (!defined('ABSPATH')) {
    exit;
}


//Add database table while plugin activated ;
register_activation_hook(__FILE__, 'wpb_activation_callback' );

function wpb_activation_callback(){

    global $wpdb ;

        $wpb_sql_for_table_altering = "ALTER TABLE `{$wpdb -> prefix}woocommerce_order_items` ADD IF NOT EXISTS `customer_dir` VARCHAR(255) NOT NULL AFTER `order_id`";

        $wpdb -> query($wpb_sql_for_table_altering);      

    $wpdb -> query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wpb_upload_items (
        order_id BIGINT UNSIGNED NOT NULL,
        upload_date DATE NOT NULL,
        uploaded_file varchar(255) NOT NULL)");
    }

    function wpb_load_textdomain(){
        load_plugin_textdomain('wooocommerce-package-builder', false, dirname(plugin_basename( __FILE__ )) . '/lang' );
    }
    
    add_action('plugin_loaded', 'wpb_load_textdomain');

add_action('add_meta_boxes', 'wpb_order_meta_box');

function wpb_order_meta_box(){
    add_meta_box('wpb-order-dir', 'Order Upload Directory', 'wpb_order_metabox_callback', 'shop_order');    
}

function wpb_order_metabox_callback($post){

    global $wpdb; 

    $order_id = $post -> ID;

    $order_query = $wpdb -> get_results("SELECT * FROM {$wpdb -> prefix}woocommerce_order_items WHERE order_id = $order_id", OBJECT);

    $upload = wp_upload_dir() ;
    $upload_dir = $upload['basedir'] . '/wpb/order_dir/'. $order_query[0] -> customer_dir ;
    $upload_url = $upload['baseurl'] . '/wpb/order_dir/'. $order_query[0] -> customer_dir ;


    
    $uploaded_files = array_diff(scandir($upload_dir), array('.', '..'));


    ?>
<ul class="wpb-uploaded-docs">
    <li class="wpb-table-title">
        <span class="wpb_up_filename"><?php echo __('File Names', 'woocommerce-package-builder');?></span>
        <span class="wpb_up_download"><?php echo __('Download Files', 'woocommerce-package-builder');?></span>
    </li>
    <?php foreach($uploaded_files as $file):?>
    <li class="wpb-uploaded-item">
        <span class="wpb-item-name"><?php echo $file?></span>
        <a href="<?php echo $upload_url . '/' . $file;?>" class="wpb-item-download button button-primary"
            download><?php echo __('Download', 'woocommerce-package-builder')?> &#x21c5;</a>
    </li>
    <?php endforeach ;?>

</ul>
<?php
}







// Test to see if WooCommerce is active (including network activated).
$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';

if (
    in_array( $plugin_path, wp_get_active_and_valid_plugins() )
    || in_array( $plugin_path, wp_get_active_network_plugins() )
) {
    define('WPB_DIRECTORY', plugin_dir_url(__FILE__));

    // Enqueue Css File 
    include(plugin_dir_path(__FILE__) . 'inc/wpb-styles.php');

    // Enqueue JS File
    include(plugin_dir_path(__FILE__) . 'inc/wpb-scripts.php');

    // Enqueue Settings & Menus 
    include(plugin_dir_path(__FILE__) . 'inc/wpb-settings.php');

    // Shortcodes for package loops
    include(plugin_dir_path(__FILE__). 'inc/wpb-shortcodes.php');

    // WPB Functions
    include(plugin_dir_path(__FILE__). 'inc/wpb-functions.php');

    if(!function_exists('wpb_include_acf')){
        
        function wpb_include_acf(){
                        // Define path and URL to the ACF plugin.
            define( 'MY_ACF_PATH', plugin_dir_path(__FILE__) . 'inc/acf/' );
            define( 'MY_ACF_URL', plugin_dir_url(__FILE__) . 'inc/acf/' );

            // Include the ACF plugin.
            include_once( MY_ACF_PATH . 'acf.php' );

            // Customize the url setting to fix incorrect asset URLs.
            add_filter('acf/settings/url', 'wpb_acf_settings_url');
            function wpb_acf_settings_url( $url ) {
                return MY_ACF_URL;
            }

            // (Optional) Hide the ACF admin menu item.
            add_filter('acf/settings/show_admin', 'wpb_acf_settings_show_admin');
            function wpb_acf_settings_show_admin( $show_admin ) {
                return true;
            }
        }

        wpb_include_acf() ;

    }
    
    add_filter('woocommerce_locate_template','wpb_locate_woo_templates', 10, 3);
        /**
             * Filter the cart template path to use cart.php in this plugin instead of the one in WooCommerce.
             *
             * @param string $template      Default template file path.
             * @param string $template_name Template file slug.
             * @param string $template_path Template file name.
             *
             * @return string The new Template file path.
         */

    function wpb_locate_woo_templates($template, $template_name, $template_path){

        $template_directory = trailingslashit( plugin_dir_path(__FILE__) ) . 'woocommerce/';

        $path = $template_directory . $template_name ;

        return file_exists( $path ) ? $path : $template ;

    }

    
}

else{
    if (!function_exists('install_woofirst')) {
        function install_woofirst()
        {
    ?>
<div class="notice notice-error">
    <p><?php _e('Install woocommerce to use Woocommerce Package Builder', 'woocommerce-package-builder') ?></p>
</div>
<?php
        }

        add_action('admin_notices', 'install_woofirst');
    }

}

register_uninstall_hook( __FILE__ , 'wpb_uninstall_callback' );

function wpb_uninstall_callback(){

    global $wpdb ;

    $wpdb -> query("DROP TABLE {$wpdb-> prefix}wpb_upload_items");
    $wpdb -> query("ALTER TABLE {$wpdb -> prefix}woocommerce_order_items DROP COLUMN customer_dir");

}