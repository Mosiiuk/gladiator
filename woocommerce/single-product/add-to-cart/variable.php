<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

$leveling_slider = false;
$leveling_count  = 0;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart"
  action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
  method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>"
  data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
  <?php do_action( 'woocommerce_before_variations_form' ); ?>

  <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
  <p class="stock out-of-stock">
    <?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?>
  </p>
  <?php else : ?>

  <div class="cart_options_item buy_now">

    <?php woocommerce_single_variation_add_to_cart_button() ?>

  </div>

  <div class="cart_options_item variations">



		<?php foreach ( $attributes as $attribute_name => $options ) : ?>
			
			<?php 
			if( $attribute_name == 'Current Level'){
				$leveling_slider  = true;
				$firstValue       = reset($options);
				$leveling_count++;
				$slider_min_steps = implode(',', $options); 

				if($leveling_slider == true && $leveling_count == 1){echo '<div class="options_item rating__table__item"><div class="inputs_range">';};

			?>

				<label for="min-value">
					<?php _e('Your current lvl:', 'gladiator'); ?>
					<input type="text" 
					id='min-value' 
					name="attribute_current-level" 
					data-attribute_name="attribute_current-level" 
					data-min='<?php echo $firstValue;?>' 
					data-steps='<?php echo $slider_min_steps;?>'>
				</label>

			<?php 
				} if( $attribute_name == 'Desired Level'){
					$lastValue = end($options);
					$leveling_count++;
					$slider_max_steps = implode(',', $options); 

			?>

				<label for="max-value">
					<?php _e('Lvl you want:', 'gladiator'); ?>
					<input type="text" 
					id='max-value' 
					name="attribute_desired-level" 
					data-attribute_name="attribute_desired-level" 
					data-max='<?php echo $lastValue;?>' 
					data-steps='<?php echo $slider_max_steps;?>'>
				</label>

			<?php 
			if($leveling_slider == true && $leveling_count == 2){echo '<div id="range_result"></div></div></div>';};
			
			} 
			?>

			
			<div class="options_item rating__table__item <?php if(!$leveling_slider == false){echo 'hidden';}; ?>">

				<h5><?php echo wc_attribute_label( $attribute_name ); ?>:</h5>
				<?php
					wc_dropdown_variation_attribute_options(
						array(
							'options'   => $options,
							'attribute' => $attribute_name,
							'product'   => $product,
							'class'		=> "product_select"
						)
					);
				?>
			</div>
			<?php 

			if($leveling_slider == true && $leveling_count == 2){$leveling_slider = false;};

    	endforeach; 

		do_action( 'woocommerce_before_single_variation' );
		do_action( 'woocommerce_single_variation' );
		
		?>

  </div>

  <?php endif; ?>

  <?php do_action( 'woocommerce_after_variations_form' ); ?>

  

</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );