<?php

// Adding Settings Sub Page

if(! function_exists('wpb_settings_page')){

    function wpb_settings_markup(){

        global $wpdb;

        //Database Query ;
        
        $results = $wpdb -> get_results( "SELECT * FROM {$wpdb -> prefix}woocommerce_order_items", OBJECT);

        ?>

<div class="wrap wpb-container">
    <h1><i class="fa-solid fa-database"></i> WPB Order Data Table</h1>

    <div class="overflow-x-auto">
        <div class=" flex items-center justify-center  font-sans overflow-hidden">
            <div class="w-full lg:w-6/6 mx-5">
                <div class="bg-white rounded-[5px] overflow-hidden  shadow-md  my-6">
                    <table class="wpb-settings-table min-w-max w-full table-auto bg-gray-100">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 capitalize text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Order ID</th>
                                <th class="py-3 px-6 text-left">Product Name</th>
                                <th class="py-3 px-6 text-center">Customer Directory</th>
                                <th class="py-3 px-6 text-center">Uploaded Files</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <?php foreach($results as $result):?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="wpb-table-order-id">
                                            <?php echo $result -> order_id ;?>
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span><?php echo $result -> order_item_name;?></span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center">
                                        <?php echo $result -> customer_dir;?>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center">
                                        <?php 
                                        $upload = wp_upload_dir() ;
                                        $upload_dir = $upload['basedir'] . '/wpb/order_dir/'. $result-> customer_dir ;
                                        $upload_url = $upload['baseurl'] . '/wpb/order_dir/'. $result -> customer_dir ;
                                    
                                        $uploaded_files = array_diff(scandir($upload_dir), array('.', '..'));
                                    ?>
                                        <marquee width="200px">
                                            <?php foreach($uploaded_files as $file):?>
                                            <?php echo $file . " , " ;?>
                                            <?php endforeach ;?>
                                        </marquee>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <a
                                                href="<?php echo get_admin_url() . 'post.php?post='.$result -> order_id.'&action=edit'?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ;?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }

    function wpb_settings_page(){

        add_submenu_page(
            'woocommerce',
            'Woocommerce Package Builder',
            'Woo Package Builder',
            'manage_options',
            'wpb',
            'wpb_settings_markup',10 
        );
            
    }

    add_action('admin_menu', 'wpb_settings_page');

}