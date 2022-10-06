<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

global $order;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : 
        $index = -1;
    ?>

<div
    class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">

    <?php foreach($customer_orders -> orders as $customer_order):
            $index++;
			$order = wc_get_order($customer_order);
		?>
    <div class="wpb-order-section">
        <h2 class="wpb-order-subtitle">

            La commande n°<?php echo $order -> get_id() ;?> a été passée le
            <?php echo __(date_format($order -> get_date_created(),"F"), 'woocommerce-package-builder') . date_format($order -> get_date_created(), " j, Y") ; ?>
            et
            est
            actuellement
            : <span
                class="wpb-order-status"><?php echo __(str_replace("-", " ", $order -> get_status()), 'woocommerce-package-builder') ;?></span>
        </h2>
        <h1 class="wpb-order-title">
            Mises à jour de la commande
        </h1>
        <div class="wpb-order-list">
            <div class="wpb-order-listitem">
                <span>lundi 21 mars 2022, 04:10</span>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                </p>
            </div>
            <div class="wpb-order-listitem">
                <span>lundi 21 mars 2022, 04:10</span>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                </p>
            </div>
        </div>

        <div class="wpb-order-documents">
            <h2>Télécharger les documents de ma commande</h2>
            <table class="wpb-document-table">
                <thead>
                    <tr>
                        <td>Nom du document</td>
                        <td>Date</td>
                        <td>Téléchargement</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 

                            $downloads = $order -> get_downloadable_items() ;
                            // echo '<pre>';
                            // print_r($test);
                            // echo '</pre>';
                            ?>
                    <?php foreach($downloads as $download):?>
                    <tr>
                        <td class="wpb_download-filename">
                            <?php echo $download['file']['name']?>
                        </td>
                        <td class="wpb_download-date">
                            <?php echo date_format($order -> get_date_created(), 'd/m/Y')?>
                        </td>
                        <td class="wpb_download-link">
                            <a href="<?php echo $download['download_url']?>">télécharger</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>

        <div class="wpb_upload_docs">
            <?php do_action('wpb_upload_docs_handle');?>
        </div>

        <!-- Order Item Details -->
        <div class="wpb_ordered_product_info">
            <h1 class="wpb-order-title">
                Détails de la commande
            </h1>
            <table class="wpb-document-table">
                <thead>
                    <tr>
                        <td>Service</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($order -> get_items() as $item):?>
                    <tr>
                        <td>
                            <?php echo $item -> get_name()?>
                        </td>
                        <td>
                            <?php echo $item -> get_total() . get_woocommerce_currency_symbol();?>
                        </td>
                    </tr>
                    <?php endforeach ;?>

                    <tr>
                        <td>
                            Expédition
                        </td>
                        <td>
                            <?php echo $order -> get_shipping_method() ? $order -> get_shipping_method() : "- -";?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Moyen de paiement
                        </td>
                        <td>
                            <?php echo $order->get_payment_method_title();?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Order Item Details Ends-->

        <!-- Address Area -->

        <div class="wpb_address-section">
            <div class="wpb_billing">
                <h1 class="wpb-order-title">
                    Adresse de facturation
                </h1>
                <ul class="wpb_address_details">
                    <li><?php echo $order->get_formatted_billing_full_name();?></li>
                    <li><?php echo strtoupper($order ->get_billing_company());?></li>
                    <li><?php echo strtoupper($order->get_billing_address_1());?></li>
                    <li><?php echo strtoupper($order->get_billing_address_2());?></li>
                    <li><?php echo $order->get_billing_phone();?></li>
                    <li><?php echo strtolower($order->get_billing_email());?></li>
                </ul>
            </div>
            <div class="wpb_shipping">
                <h1 class="wpb-order-title">
                    Adresse de livraison
                </h1>
                <ul class="wpb_address_details">
                    <li><?php echo $order->get_formatted_shipping_full_name();?></li>
                    <li><?php echo strtoupper($order ->get_shipping_company());?></li>
                    <li><?php echo strtoupper($order->get_shipping_address_1());?></li>
                    <li><?php echo strtoupper($order->get_shipping_address_2());?></li>
                    <li><?php echo $order->get_billing_phone();?></li>
                    <li><?php echo strtolower($order->get_billing_email());?></li>
                </ul>
            </div>
        </div>

        <!-- Address Area Ends -->
    </div>
    <?php endforeach ;?>










</div>

<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
    <?php if ( 1 !== $current_page ) : ?>
    <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button"
        href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
    <?php endif; ?>

    <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
    <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button"
        href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php else : ?>
<div
    class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
    <a class="woocommerce-Button button"
        href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></a>
    <?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>