<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="info__top shop_table woocommerce-checkout-review-order-table">
    <div class="b-form">
        <h4>Your Order</h4>
        <table class="order__table">
			<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-name">
							<div class="product__title js-product-title"><?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ); ?></div>
							<?php echo gladiator_render_cart_item_details( $cart_item ); ?>
						</td>
						<td>
							<div class="quantity__val"><?php echo $cart_item['quantity']; ?></div>
						</td>
						<td class="product-total d-flex justify-content-end">
							<div class="product__price js-product-price"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></div>
						</td>
					</tr>
					<?php
				}
			}
			do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
        </table>
    </div>
    <!-- <div class="b-form">
        <h4>Discount</h4>
        <div class="input__group form__apply js-form-apply">
            <input type="text" id="checkout_discount" placeholder="Discount Code">
            <div class="btn">
                <a class="checkout_discount_button" href="#">Apply</a>
            </div>
        </div>
    </div> -->

	<?php if( WC()->cart->get_coupons()){ ?>

		<div class="total__price additional_price <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
		
			<div class="current__price totals_subtotal"><?php wc_cart_totals_subtotal_html(); ?></div>

		</div>
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>

			<div class="total__price additional_price cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> current__price"><span data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></span></div>

		<?php endforeach; ?>
	<?php } ?>


	
	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

    <div class="total__price">
        <h4>Total</h4>
        <div class="current__price"><?php wc_cart_totals_order_total_html(); ?></div>
    </div>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>
