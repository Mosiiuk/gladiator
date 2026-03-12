<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>




<div class="woocommerce-variation-add-to-cart variations_button price__section">

    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', 1, $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>


    <div class="price">
        <?php woocommerce_single_variation() ?>
    </div>

    <div class="hidden-field">
        <p class="form-row product-coupon form-row-wide" id="product-coupon_field" data-priority="">
            <label for="product-coupon" class="">
                <span class="promocode"><?php _e('I have promocode', 'gladiator'); ?></span>
            </label>
            <span class="woocommerce-input-wrapper hidden">
                <input type="text" class="input-text " name="product-coupon" id="product-coupon"
                    placeholder="<?php _e('Enter promocode', 'gladiator'); ?>" value="">
            </span>
        </p>
    </div>

    <div class="buttons btn">

        <button type="submit"
            class="add_to_cart single_add_to_cart_button button alt"><?php _e('Buy now', 'gladiator'); ?></button>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

        <button type="button" class="start_chat">
            <?php _e('Start chat', 'gladiator'); ?>
        </button>

    </div>

<!--    <button type="button" class="found_cheaper" data-toggle="modal" data-target="#found_cheaperModal">-->
<!--        --><?php //_e('Found cheaper? We price match!', 'gladiator'); ?>
<!--    </button>-->

  <button type="button" class="found_cheaper" data-toggle="modal" data-target="#found_cheaperModal">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M13.7365 21.8481C15.0297 21.62 16.2654 21.1395 17.373 20.4339C18.4806 19.7283 19.4383 18.8115 20.1915 17.7358C20.9448 16.66 21.4787 15.4465 21.763 14.1644C22.0472 12.8823 22.0761 11.5568 21.8481 10.2635C21.62 8.97025 21.1395 7.73456 20.4339 6.627C19.7283 5.51945 18.8115 4.56171 17.7358 3.80848C16.66 3.05525 15.4465 2.52127 14.1644 2.23704C12.8823 1.95281 11.5568 1.92388 10.2635 2.15192C8.97025 2.37996 7.73456 2.86049 6.627 3.56609C5.51945 4.27168 4.56171 5.18851 3.80848 6.26424C3.05525 7.33996 2.52127 8.55352 2.23704 9.83561C1.95281 11.1177 1.92388 12.4432 2.15192 13.7365C2.37996 15.0298 2.86049 16.2654 3.56609 17.373C4.27168 18.4806 5.18851 19.4383 6.26424 20.1915C7.33996 20.9448 8.55352 21.4787 9.83561 21.763C11.1177 22.0472 12.4432 22.0761 13.7365 21.8481L13.7365 21.8481Z" stroke="white"/>
      <path d="M12 12L12 18" stroke="white" stroke-linecap="square"/>
      <path d="M12 7L12 6" stroke="white" stroke-linecap="square"/>
    </svg>

    <?php _e('What happens after order?', 'gladiator'); ?>
  </button>

    <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
    <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
    <input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>