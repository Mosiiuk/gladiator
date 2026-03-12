<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<section class="section__intro__mini">
	<?php if(get_field('header_backgroud_image')){ ?>
        <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('header_backgroud_image')['url']; ?>"></div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h1>Information</h1>

            </div>
        </div>
    </div>
</section>



<section class="section__payinfo">
    <div class="container">
        <?php  do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

        <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

            <input type="text" name="coupon_code" class="input-text" id="checkout_coupon_code" value="" />

            <button type="submit" class="button" name="apply_coupon" id="checkout_coupon_code_button"  value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"></button>

        </form>

		<form name="checkout"   method="post" class="checkout woocommerce-checkout row" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            
            <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
        
            <div class="col-lg-7">
                <div class="b-form">

                    <?php if ( $checkout->get_checkout_fields() ) { ?>

                        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                        <?php do_action( 'woocommerce_checkout_billing' ); ?>


                        <div class="order-details__payment-details">
                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                        </div>

                        <div class="input__group">
                            <input type="text" required name="billing_discord_id" class="input-text" id="billing_discord_id" value="" placeholder="<?php esc_attr_e( 'Discord Tag', 'woocommerce' ); ?>" />                            
                        </div>
                        <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
                            <div class="input__group">
                                <textarea name="order_comments" placeholder="Game ID/Username & Server (if applicable)"><?php echo $checkout->get_value( $key ) ?></textarea>
                            </div>
                        <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>


                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>


                    <?php } ?>

                    <?php woocommerce_checkout_payment() ?>
                </div>
            </div>

            <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

            <div id="order_review" class="woocommerce-checkout-review-order col-lg-5 d-flex flex-column justify-content-between">
                
                <?php do_action( 'woocommerce_checkout_order_review' ); ?>

                <div class="submit__group">

                    <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

                    <?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Continue to payment" data-value="Continue to payment">Continue to payment</button>' ); // @codingStandardsIgnoreLine ?>

                    <?php do_action( 'woocommerce_review_order_after_submit' ); ?>
                
                </div>
            </div>
            
            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>                

		</form>
	</div>
</section>


<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>


<section class="section__bottom__text">
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


