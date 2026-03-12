<?php

if ( ! defined( 'ABSPATH' ) ){ 
    exit;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

remove_action( 'woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 60 );

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

add_filter( 'woocommerce_get_script_data', 'change_alert_text', 10, 2 );
function change_alert_text( $params, $handle ) {
    if ( $handle === 'wc-add-to-cart-variation' )
        $params['i18n_no_matching_variations_text'] = __( 'Wrong rating', 'domain' );

    return $params;
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


function sp_woocommerce_script_cleaner() {
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce_frontend_styles');
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-smallscreen');
}
add_action('wp_enqueue_scripts', 'sp_woocommerce_script_cleaner', 99);


add_filter( 'woocommerce_cart_totals_order_total_html', 'totals_remove_strong' );
function totals_remove_strong( $value ){
	$value = str_replace( array('<strong>', '</strong>'), array('', ''), $value);

	return $value;
}


function find_variation_id($product, $attributes)
{
    $WC_Product_Data_Store_CPT = new WC_Product_Data_Store_CPT();
    return $WC_Product_Data_Store_CPT->find_matching_product_variation(
        $product,
        $attributes
    );
}



function theme_modify_stripe_fields_styles( $styles ) {
    return array(
        'base' => array(
            'iconColor'     => '#7e7e7e',
            'color'         => '#fff',
            '::placeholder' => array(
                'color' => '#7e7e7e',
            ),
        ),
    );
}

add_filter( 'wc_stripe_elements_styling', 'theme_modify_stripe_fields_styles' );


// product page

remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );

remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );



// Apply the coupon code from product custom text imput field
add_filter('woocommerce_add_cart_item_data', 'coupon_code_product_add_to_cart', 20, 3);
function coupon_code_product_add_to_cart($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['product-coupon']) && ! empty($_POST['product-coupon'])) {
        WC()->cart->apply_coupon( sanitize_title( $_POST['product-coupon'] ) );
    }
    return $cart_item_data;
}

//----- DELETE ORDERS >24h OnHold status ----
add_action( 'init', 'del_orders24h' );
function del_orders24h()
{
    if (isset($_GET['del_orders24h']) && (int)$_GET['del_orders24h']==90210)
    {
        $args = [
            'post_type'      => 'shop_order',
            'post_status'    => 'wc-on-hold',
            'date_query'     => [
                [
                    'column' => 'post_date',
                    'before' => '24 hours ago',
                ],
            ],
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);


        if (!empty($query->posts))
        {
            foreach ($query->posts as $order_id)
            {
                wp_delete_post($order_id->ID, true);
            }
        }

        exit;
    }
}

