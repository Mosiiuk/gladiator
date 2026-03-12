<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<?php if( WC()->cart->get_coupons()){ ?>
		<div class="current__price totals_subtotal"><?php wc_cart_totals_subtotal_html(); ?></div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>

			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> current__price"><span data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></span></div>

		<?php endforeach; ?>
	<?php } ?>

	<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

	<div class="current__price"><?php wc_cart_totals_order_total_html(); ?></div>



    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <div class="fee">
            <div class="fee_name"><?php echo esc_html( $fee->name ); ?></div>
            <div class="fee_value" data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></div>
        </div>
    <?php endforeach; ?>

	<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->
