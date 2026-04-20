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
      <path d="M12.33 2.64L18.33 5.31C18.81 5.52 19.12 6 19.12 6.53V10.5C19.12 15.27 16.2 19.73 12.33 21.36C12.12 21.45 11.88 21.45 11.67 21.36C7.8 19.73 4.88 15.27 4.88 10.5V6.53C4.88 6 5.19 5.52 5.67 5.31L11.67 2.64C11.88 2.55 12.12 2.55 12.33 2.64Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M9.25 11.75L11.35 13.85L15 10.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>

    <?php _e('Our Guarantees', 'gladiator'); ?>
  </button>

    <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
    <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
    <input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
