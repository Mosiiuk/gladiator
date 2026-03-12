<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.3
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment">

	<h4>Payment</h4>
	
	<p>All transactions are secure and encrypted.</p>

	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="tabs__head js-tab-head-box">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $key => $gateway ) {
					?>
						<li>
							<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
								<a href="#" class="<?php if($gateway->chosen){ echo 'active';} ?> js-tab-head" data-target="#label_payment_method_<?php echo esc_attr( $gateway->id ); ?>"><?php echo $gateway->get_title(); ?>
								</a>
							</label>
							<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio d-none" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
						</li>
					<?php

					
				}
			}
			?>
		</ul>
	<?php endif; ?>

	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="tabs__body wc_payment_methods payment_methods methods">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			}
			?>
		</ul>
	<?php endif; ?>
	<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
