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

function gladiator_get_cart_item_custom_value( $cart_item, $keys ) {
	foreach ( $keys as $key ) {
		if ( isset( $cart_item[ $key ] ) && $cart_item[ $key ] !== '' ) {
			return $cart_item[ $key ];
		}

		if ( isset( $cart_item['custom_data'][ $key ] ) && $cart_item['custom_data'][ $key ] !== '' ) {
			return $cart_item['custom_data'][ $key ];
		}
	}

	return '';
}

function gladiator_format_cart_item_detail_value( $value, $taxonomy = '' ) {
	if ( is_array( $value ) ) {
		$value = implode( ', ', array_filter( array_map( 'gladiator_format_cart_item_detail_value', $value ) ) );
	}

	$value = trim( wp_strip_all_tags( (string) $value ) );

	if ( $value === '' ) {
		return '';
	}

	if ( $taxonomy && taxonomy_exists( $taxonomy ) ) {
		$term = get_term_by( 'slug', $value, $taxonomy );

		if ( $term && ! is_wp_error( $term ) ) {
			return $term->name;
		}
	}

	if ( strpos( $value, ' ' ) === false && ( strpos( $value, '-' ) !== false || strpos( $value, '_' ) !== false ) ) {
		return ucwords( str_replace( array( '-', '_' ), ' ', $value ) );
	}

	return $value;
}

function gladiator_get_cart_item_details( $cart_item ) {
	$details = array();
	$seen    = array();

	$append_detail = function( $label, $value ) use ( &$details, &$seen ) {
		$label = trim( wp_strip_all_tags( (string) $label ) );
		$value = gladiator_format_cart_item_detail_value( $value );

		if ( $label === '' || $value === '' ) {
			return;
		}

		$detail_key = strtolower( $label . '|' . $value );

		if ( isset( $seen[ $detail_key ] ) ) {
			return;
		}

		$details[]          = array(
			'label' => $label,
			'value' => $value,
		);
		$seen[ $detail_key ] = true;
	};

	if ( ! empty( $cart_item['variation'] ) && is_array( $cart_item['variation'] ) ) {
		foreach ( $cart_item['variation'] as $attribute_name => $attribute_value ) {
			if ( $attribute_value === '' ) {
				continue;
			}

			$taxonomy = str_replace( 'attribute_', '', $attribute_name );
			$label    = wc_attribute_label( $taxonomy );
			$value    = gladiator_format_cart_item_detail_value( $attribute_value, $taxonomy );

			$append_detail( $label, $value );
		}
	}

	if ( ! empty( $cart_item['addons'] ) && is_array( $cart_item['addons'] ) ) {
		foreach ( $cart_item['addons'] as $addon ) {
			if ( empty( $addon['value'] ) ) {
				continue;
			}

			$label = ! empty( $addon['name'] ) ? $addon['name'] : __( 'Option', 'gladiator-theme' );
			$append_detail( $label, $addon['value'] );
		}
	}

	$server = gladiator_get_cart_item_custom_value(
		$cart_item,
		array( 'server', 'money_server', 'server_name', 'selected_server' )
	);

	if ( $server !== '' ) {
		$append_detail( __( 'Server', 'gladiator-theme' ), $server );
	}

	$amount = gladiator_get_cart_item_custom_value(
		$cart_item,
		array( 'money_qtn', 'money_amount', 'custom_amount', 'amount' )
	);

	if ( $amount !== '' ) {
		$unit = gladiator_get_cart_item_custom_value(
			$cart_item,
			array( 'unit', 'money_unit' )
		);

		if ( $unit !== '' && stripos( (string) $amount, (string) $unit ) === false ) {
			$amount .= ' ' . $unit;
		}

		$append_detail( __( 'Amount', 'gladiator-theme' ), $amount );
	}

	return $details;
}

function gladiator_render_cart_item_details( $cart_item ) {
	$details = gladiator_get_cart_item_details( $cart_item );

	if ( empty( $details ) ) {
		return '';
	}

	ob_start();
	?>
	<div class="product__details">
		<?php foreach ( $details as $detail ) : ?>
			<div class="product__detail">
				<span class="product__detail-label"><?php echo esc_html( $detail['label'] ); ?>:</span>
				<span class="product__detail-value"><?php echo esc_html( $detail['value'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<?php

	return ob_get_clean();
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
