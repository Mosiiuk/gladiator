<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); 
$checkout = new WC_Checkout();
?>

<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
<section class="section__intro__mini section__intro__cart section__cart">
	<?php if(get_field('header_backgroud_image')){ ?>
		<div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('header_backgroud_image')['url']; ?>"></div>
	<?php } ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<h1>Your cart</h1>
			</div>
		</div>
		<form class="row woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
			<div class="col-lg-12">
				<div class="table__cart js-table-cart">

					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
							<tr>
								<th style="width: 41%;">
									Name
								</th>
								<th>
									Quantity
								</th>
								<th>

								</th>
								<th>

								</th>
							</tr>
							
								<?php do_action( 'woocommerce_before_cart_contents' ); ?>

								<?php
								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
										$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
										<tr class="js-product-cart woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">


											<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
												<div class="product__title js-product-title"><?php echo $_product->get_name() ?></div>
												<?php echo gladiator_render_cart_item_details( $cart_item ); ?>
												<?php

												do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

												// Backorder notification.
												if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
												}
												?>
											</td>

											<td>
												<div class="quantity__block js-quantity-block">
													<button class="quantite__arrow js-quantity-arrow-minus"> - </button>
													<?php
														if ( $_product->is_sold_individually() ) {
															$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
														} else {
															$product_quantity = woocommerce_quantity_input(
																array(
																	'input_name'   => "cart[{$cart_item_key}][qty]",
																	'input_value'  => $cart_item['quantity'],
																	'max_value'    => $_product->get_max_purchase_quantity(),
																	'min_value'    => '0',
																	'product_name' => $_product->get_name(),
																	'classes'	   => 'quantity__num js-quantity-num'
																),
																$_product,
																false
															);
														}

														echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
													?>
													<button class="quantite__arrow js-quantity-arrow-plus"> + </button>
												</div>
											</td>

											<td>
												<div class="product__price "><?php
													echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
												?></div>
											</td>

											<td class="product-remove">
												<?php
													echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
														'woocommerce_cart_item_remove_link',
														sprintf(
															'<a href="%s" aria-label="%s" data-product_id="%s" data-product_sku="%s" class="close__product">Remove <span  class="close"></span></a>',
															esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
															esc_html__( 'Remove this item', 'woocommerce' ),
															esc_attr( $product_id ),
															esc_attr( $_product->get_sku() )
														),
														$cart_item_key
													);
												?>
											</td>

										</tr>
										<?php
									}
								}
								?>

								<?php do_action( 'woocommerce_cart_contents' ); ?>

								<?php do_action( 'woocommerce_after_cart_contents' ); ?>
					</table>

					<?php do_action( 'woocommerce_after_cart_table' ); ?>

                    <?php
                        $how_much_gbcoin = GBCoin::get_instance()->how_much_gbcoin();
                        if( $how_much_gbcoin!==false )
                        {
                            echo "
                                <div class='gbcoin_buying'>
                                   GBCoin: + $how_much_gbcoin <div class='info_icon'>?</div>
                                         <div class='popover_coin_wrap'>
                                        <div class='popover_coin_text'>
                                           ".get_field('cart_gbcoin_text', 'option')."
                                        </div>
                                    </div>
                                </div>";
                        }
                    ?>

				</div>
			</div>

			

			



			<div class="col-lg-7">
				
				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="b-form discount">
						<h4>Discount</h4>
						<div class="input__group form__apply js-form-apply active">
							<input type="text" name="coupon_code"  placeholder="Discount Code" id="coupon_code">
							<div class="btn">
								<button type="submit" name="apply_coupon" >Apply</button>
							</div>
						</div>
					</div>
				<?php } ?>

				<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			</div>

            <!-- GBCoin-->
            <div class="col-lg-7">
                    <div class="b-form discount">
                        <h4>GBCoin</h4>
                        <?php
                            $is_set_bgcoin = GBCoin::get_instance()->is_set_bgcoin();
                            $count_set_bgcoin = GBCoin::get_instance()->count_set_bgcoin();
                        ?>
                        <div class="input__group form__apply js-form-apply active">
                            <?php
                                if ( !$is_set_bgcoin ) {
                            ?>
                                <input type="number" name="gbcoin"  placeholder="GBCoin" id="gbcoin">
                            <?php } else { ?>
                                <input type="number" name="gbcoin" value="<?php echo $count_set_bgcoin;?>"  placeholder="GBCoin" id="gbcoin" disabled >
                            <?php } ?>
                            <div id="gbcoin_info" class="gbcoin_hidden">

                            </div>
                            <div class="btn">
                                <?php
                                    if ( !$is_set_bgcoin ) {
                                ?>
                                    <button type="button" id="set_gbcoin" name="apply_coupon" >Apply</button>
                                <?php } else { ?>
                                        <button type="button" id="cancel_gbcoin" name="cancel_gbcoin" >Cancel</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /GBCoin-->

			<div class="col-lg-1 offset-lg-1">
				<h4>Total</h4>
			</div>

			<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

			<div class="cart-collaterals col-lg-3">
				<?php
					/**
					 * Cart collaterals hook.
					 *
					 * @hooked woocommerce_cross_sell_display
					 * @hooked woocommerce_cart_totals - 10
					 */
					do_action( 'woocommerce_cart_collaterals' );
				?>
			</div>
			<?php do_action( 'woocommerce_after_cart' ); ?>
		</form>
		
	</div>
</section>


<section class="section__bottom__text gradioent__top">
    <?php if(get_field('bottom_background_image', 'footer')){ ?>
    <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('bottom_background_image', 'footer')['url']; ?>"></div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="have__questions__text">
                    <?php the_field('have_question', 'footer'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->
