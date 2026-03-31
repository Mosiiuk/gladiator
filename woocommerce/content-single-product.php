<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.

	return;
}

$upload_dir = wp_get_upload_dir();

?>
<!-- [ <?php echo str_replace($_SERVER["DOCUMENT_ROOT"], '', __FILE__); ?> -->

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<?php
	$header_accordion       = get_field( 'header_image' ); // Use the field name of the accordion
	$product_overall_rating = get_field( 'product_overall_rating', 'options' ); // Use the field name of the accordion

	// Now, retrieve the nested image field
	$header_image = $header_accordion['header_image'] ?? '';

	// Default image fallback if the custom field is empty
	if ( ! $header_image ) {
		$upload_dir   = wp_upload_dir();
		$header_image = $upload_dir['baseurl'] . '/2021/04/background_img_4.jpg';
	}

	?>

	<?php

	if ( $product->get_type()=='product_game_money' ) { ?>

    <?php
        $product_id = $product->get_id();

        $server_list = get_post_meta($product_id, '_server_list', true);
        $money_items = get_post_meta($product_id, '_money_items', true);

    ?>
    <!-- MONEY PRODUCT -->

  <section class="section__intro__mini section__intro__job "
           style="background-image:url(<?php echo esc_url( $header_accordion['url'] ); ?>); background-repeat: no-repeat;" >

    <div class="container-fluid">

      <div class="row">

        <div class="col-lg-12">

          <div class="modile_title_wrap">

            <div class="modile_title_item">

              <ul class="navbar"><?php gladiator_render_product_breadcrumb( get_the_ID() ); ?></ul>

              <div class="product_title_wrap">

                <h1><?php the_title(); ?></h1>
                <div class="product_reviews">
                <span>
                    Overall rating
                </span>

                  <img src="<?php echo get_template_directory_uri(); ?>/img/reviews1.png" alt="alt">
                  <span class="reviews_count"><?php echo $product_overall_rating; ?>+ reviews</span>
                </div>
              </div>


            </div>

          </div>

          <div class="modile_title"></div>

          <div class="gold_cart">

            <div class="product_spec_choose">

              <div class="server_choose_wrap">

                <div class="server_choose_title">
                  <p>Choose your server</p>
                </div>

                <div class="server_choose_list">

                    <?php
                        $current_currency = get_woocommerce_currency();
                       // $exchange_rate = get_woocommerce_currency_exchange_rate( $current_currency );

                        if ( is_array($server_list) && count($server_list) )
                        {
                            $ser_sh='checked';
                            foreach( $server_list as $key=>$value)
                            {
                                $converted_amount = apply_filters('woocs_exchange_value', $value['cost'], 'EUR', $current_currency);
                                echo "
                                    <label class=\"control\">
                                        <input type=\"radio\" class='money_server_act' name=\"server\" value='$value[name]' $ser_sh data-cost='$converted_amount' data-not_convert='$value[cost]' data-qty='$value[qty]'  >
                                        <span class=\"control-indicator\">$value[name]</span>
                                      </label>
                                ";
                                $ser_sh='';
                            }
                        }
                    ?>

                </div>

              </div>

              <div class="gold_choose_wrap">
                <div class="gold_choose">

                    <?php
                        $max_min=[];
                        if ( is_array($money_items) && count($money_items) )
                        {
                            $ser_sh='checked';
                            foreach( $money_items as $key=>$value)
                            {
                                /*
                                  [name] => 70K
                                    [qty] => 70000
                                    [price] => 2.88
                                 */
                                echo "
                                        <label class=\"control\">
                                            <input type=\"radio\" class='money_item_act' name=\"money_item\"  data-name='$value[name]' data-price='$value[price]' data-unit='$value[unit]' value='$value[qty]' $ser_sh >
                                            <span class=\"control-indicator\">$value[name]</span>
                                          </label>
                                    ";
                                $ser_sh='';
                                $max_min[]=$value['qty'];
                            }
                        }

                        $minValue = min($max_min);
                        $maxValue = max($max_min);

                        $price_per = get_post_meta($product_id, '_price_per', true);
                        $per_quantity = get_post_meta($product_id, '_per_quantity', true);


                        $currency_symbol = get_woocommerce_currency_symbol( $current_currency );

//                       /* var_dump($currency_symbol);
//                        var_dump($current_currency);
//                        var_dump($exchange_rate);*/
                    ?>

                    <input type="hidden" id="money_prod_min" value="<?php echo $minValue;?>" >
                    <input type="hidden" id="money_prod_max" value="<?php echo $maxValue;?>" >

                    <input type="hidden" id="money_price_per" value="<?php echo $price_per;?>" >
                    <input type="hidden" id="money_per_quantity" value="<?php echo $per_quantity;?>" >

                </div>

                <div class="gold_custom_amount">

                  <span class="gold_custom_amount_count gold_custom_amount_minus">-</span>

                  <div class="gold_custom_amount_value">
                    <input type="number" id="gold_custom_amount_value" value="100" step="10">
                  </div>

                  <span class="gold_custom_amount_count gold_custom_amount_plus">+</span>

                </div>

                <div class="gold_total_wrap">

                  <div class="gold_total_item  ">
                    <p>Amount</p>
                    <b>
                        <span class="gold_total_item_amount">0</span>
                        <span class="gold_unit"></span>
                    </b>
                  </div>
                  <div class="gold_total_item">
                    <p>Total</p>
                    <b>
                        <span id="gold_total_sym" ><?php echo $currency_symbol;?></span>
                        <span id="gold_total_summ"  >0</span>
                    </b>
                  </div>
                </div>
              </div>
            </div>

            <div class="cart_options_wrap">
              <div class="cart_options_wrap_gold">
              <div class="cart_options_head">
                <h3>
                  Your Order
                </h3>

                <div class="cart_options_list">

                  <div class="cart_options_list_item">

                    <p>
                      Server
                    </p>

                    <b id="select_server">
                    </b>

                  </div>
                  <div class="cart_options_list_item">

                    <p>
                      Total
                    </p>

                    <b>
                        <span id="gold_total_sym_cart" ><?php echo $currency_symbol;?></span>
                        <span id="gold_total_summ_cart"  >0</span>
                    </b>

                  </div>

                  <button class="btn-main" id="money_prod_buy" data-prod_id="<?php the_ID(); ?>">Buy now</button>
                </div>

              </div>
              <div class="cart_options_footer">
                <h6>Any Questions?</h6>

                <button class="start_chat" id="mon_prod_start_chat" >start chat</button>
              </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="rating__tabs">
            <ul class="tabs__head js-tab-head-box">
							<?php if ( get_field( 'description_text' ) ) { ?>
                <li><a href="#" class="active js-tab-head"
                       data-target="#rating-body-1"><?php _e( 'Description', 'gladiator' ); ?></a></li>
							<?php } ?>
							<?php if ( get_field( 'how_to_buy_text' ) ) { ?>
                <li><a href="#" class="js-tab-head"
                       data-target="#rating-body-2"><?php _e( 'How it Works', 'gladiator' ); ?></a></li>
							<?php } ?>
							<?php if ( get_field( 'requirements_text' ) ) { ?>
                <li><a href="#" class="js-tab-head"
                       data-target="#rating-body-3"><?php _e( 'Requirements', 'gladiator' ); ?></a></li>
							<?php } ?>
							<?php if ( get_field( 'faq_text' ) ) { ?>
                <li><a href="#" class="js-tab-head"
                       data-target="#rating-body-4"><?php _e( 'FAQ', 'gladiator' ); ?></a></li><?php } ?>
            </ul>
            <ul class="rating__body">
							<?php if ( get_field( 'description_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-1"
                    style="display: block;">
								<?php the_field( 'description_text' ) ?>

                <p class="read_more_text">Read more</p>

                </li><?php } ?>
							<?php if ( get_field( 'how_to_buy_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-2">
								<?php the_field( 'how_to_buy_text' ) ?>
                <p class="read_more_text">Read more</p>
                </li><?php } ?>
							<?php if ( get_field( 'requirements_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-3">
								<?php the_field( 'requirements_text' ) ?>
                <p class="read_more_text">Read more</p>
                </li><?php } ?>
							<?php if ( get_field( 'faq_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-4">
								<?php the_field( 'faq_text' ) ?>
                <p class="read_more_text">Read more</p>
                </li><?php } ?>
            </ul>
          </div>

          <h3 class='text-left'>
						<?php _e( 'Reviews', 'gladiator' ); ?>
          </h3>

          <div class="product_reviews product_reviews_bottom">
                        <span>
                            Overall rating 5 out of 5
                        </span>

            <img src="<?php echo get_template_directory_uri(); ?>/img/reviews1.png" alt="alt">
            <span class="reviews_count"><?php echo $product_overall_rating; ?>+ reviews</span>
          </div>

          <div class="product_slider_arrows"></div>
          <div class="product_slider">

						<?php

						$attachment_ids = $product->get_gallery_image_ids();

						foreach ( $attachment_ids as $attachment_id ) {

							$image_link = wp_get_attachment_url( $attachment_id );

							echo '<div class="product_slider_image">' .
							     '<img src="' . $image_link . '" alt="alt">' .
							     '</div>';

						}

						?>

          </div>

          <div class="save_payment_wrap">
            <div class="save_payment_wrap_bg">
              <img src="<?php echo theme_url; ?>/img/save_payment_wrap_bg.png" alt="">
            </div>

            <div class="save_payment_wrap_text">
              <h2>
                Your payment is 100% Safe and Secure via Buyer Protection
              </h2>
              <p>
                You dont need to be worried, our guarantee is 100% and entire delivery of your ordered Boosting,
                Currency or Items. 24/7, 365 days a year.
              </p>
            </div>
            <div class="save_payment_img">
              <img src="<?php echo theme_url; ?>/img/big_chech.svg" alt="">
            </div>

          </div>

        </div>
      </div>


      <!-- <div class="have__questions__text">

                    <?php //the_field('have_question', 'footer'); ?>

                </div> -->

    </div>

</div>

  </section>


<!-- /MONEY PRODUCT -->

<?php } else { ?>

  <section class="section__intro__mini section__intro__job "
           style="background-image:url(<?php echo esc_url( $header_accordion['url'] ); ?>); background-repeat: no-repeat;">

    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-3 order-lg-2">

          <div class="modile_title"></div>

          <div class="cart_options_wrap">

						<?php woocommerce_template_single_add_to_cart() ?>

          </div>

        </div>

        <div class="col-lg-9 order-lg-1">

          <div class="modile_title_wrap">

            <div class="modile_title_item">

              <ul class="navbar"><?php gladiator_render_product_breadcrumb( get_the_ID() ); ?></ul>

              <div class="product_title_wrap">

                <h1><?php the_title(); ?></h1>
                <div class="product_reviews">
                                    <span>
                                        Overall rating
                                    </span>

                  <img src="<?php echo get_template_directory_uri(); ?>/img/reviews1.png" alt="alt">
                  <span class="reviews_count"><?php echo $product_overall_rating; ?>+ reviews</span>
                </div>
              </div>


            </div>

          </div>

          <div class="rating__tabs">
            <ul class="tabs__head js-tab-head-box">
							<?php if ( get_field( 'description_text' ) ) { ?>
                <li><a href="#" class="active js-tab-head"
                       data-target="#rating-body-1"><?php _e( 'Description', 'gladiator' ); ?></a></li>
							<?php } ?>
							<?php if ( get_field( 'how_to_buy_text' ) ) { ?>
                <li><a href="#" class="js-tab-head"
                       data-target="#rating-body-2"><?php _e( 'How it Works', 'gladiator' ); ?></a></li>
							<?php } ?>
							<?php if ( get_field( 'requirements_text' ) ) { ?>
                <li><a href="#" class="js-tab-head"
                       data-target="#rating-body-3"><?php _e( 'Requirements', 'gladiator' ); ?></a></li>
							<?php } ?>
							<?php if ( get_field( 'faq_text' ) ) { ?>
                <li><a href="#" class="js-tab-head"
                       data-target="#rating-body-4"><?php _e( 'FAQ', 'gladiator' ); ?></a></li><?php } ?>
            </ul>
            <!--new section -->
            <div class="advantages_section">

              <h3 class="advantages_title">What Happens After Order</h3>
              <div class="advantages-block_item_wrap d-flex">
                <div class="advantage_item wow animate__animated animate__zoomIn" data-wow-delay="0s">
                    <div class="advantage_item__step-number">1</div>
                    <img class="advantage_item__image" src="/src/assets/img/what-happens-icon-1.svg" alt="icon">
                    <p>We contact you on discord within 5 minutes of ordering</p>
                </div>
                <div class="advantage_item wow animate__animated animate__zoomIn" data-wow-delay="0.2s">
                    <div class="advantage_item__step-number">2</div>
                    <img class="advantage_item__image" src="/src/assets/img/what-happens-icon-2.svg" alt="icon">
                    <p>We confirm all details & start</p>
                </div>
                <div class="advantage_item wow animate__animated animate__zoomIn" data-wow-delay="0.4s">
                    <div class="advantage_item__step-number">3</div>
                    <img class="advantage_item__image" src="/src/assets/img/what-happens-icon-3.svg" alt="icon">
                    <p>After completion, we ask you for a review</p>
                </div>
                <div class="advantage_item wow animate__animated animate__zoomIn" data-wow-delay="0.6s">
                    <div class="advantage_item__step-number">4</div>
                    <img class="advantage_item__image" src="/src/assets/img/what-happens-icon-4.svg" alt="icon">
                    <p>We send you a discount code for next time!</p>
                </div>

              </div>
            </div>
           
            <ul class="rating__body">
							<?php if ( get_field( 'description_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-1"
                    style="display: block;">
								<?php the_field( 'description_text' ) ?>

                <p class="read_more_text">Read more</p>

                </li><?php } ?>
							<?php if ( get_field( 'how_to_buy_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-2">
								<?php the_field( 'how_to_buy_text' ) ?>
                <p class="read_more_text">Read more</p>
                </li><?php } ?>
							<?php if ( get_field( 'requirements_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-3">
								<?php the_field( 'requirements_text' ) ?>
                <p class="read_more_text">Read more</p>
                </li><?php } ?>
							<?php if ( get_field( 'faq_text' ) ) { ?>
                <li class="js-tab-body" id="rating-body-4">
								<?php the_field( 'faq_text' ) ?>
                <p class="read_more_text">Read more</p>
                </li><?php } ?>
            </ul>
          </div>

          <h3 class='text-left'>
						<?php _e( 'Reviews', 'gladiator' ); ?>
          </h3>

          <div class="product_reviews product_reviews_bottom">
                        <span>
                            Overall rating 5 out of 5
                        </span>

            <img src="<?php echo get_template_directory_uri(); ?>/img/reviews1.png" alt="alt">
            <span class="reviews_count"><?php echo $product_overall_rating; ?>+ reviews</span>
          </div>

          <div class="product_slider_arrows"></div>
          <div class="product_slider">

						<?php

						$attachment_ids = $product->get_gallery_image_ids();

						foreach ( $attachment_ids as $attachment_id ) {

							$image_link = wp_get_attachment_url( $attachment_id );

							echo '<div class="product_slider_image">' .
							     '<img src="' . $image_link . '" alt="alt">' .
							     '</div>';

						}

						?>

          </div>

          <div class="save_payment_wrap">
            <div class="save_payment_wrap_bg">
              <img src="<?php echo theme_url; ?>/img/save_payment_wrap_bg.png" alt="">
            </div>

            <div class="save_payment_wrap_text">
              <h2>
                Your payment is 100% Safe and Secure via Buyer Protection
              </h2>
              <p>
                You dont need to be worried, our guarantee is 100% and entire delivery of your ordered Boosting,
                Currency or Items. 24/7, 365 days a year.
              </p>
            </div>
            <div class="save_payment_img">
              <img src="<?php echo theme_url; ?>/img/big_chech.svg" alt="">
            </div>

          </div>

        </div>


        <!-- <div class="have__questions__text">

                    <?php //the_field('have_question', 'footer'); ?>

                </div> -->

      </div>

    </div>

  </section>

	<?php
}
?>
</div>


<div class="modal fade found_cheaperModal" id="found_cheaperModal" tabindex="-1" role="dialog"
     aria-labelledby="found_cheaperTitle"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="save_payment_wrap_bg">
        <img src="<?php echo theme_url; ?>/img/save_payment_wrap_bg.png" alt="">
      </div>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
      <div class="modal-header">
        <h5 class="modal-title" id="found_cheaperTitle">
					<?php _e( 'Our Guarantees', 'gladiator' ); ?>
        </h5>
      </div>
      <div class="modal-body">

        <div class="after_order_wrap">

          <div class="after_order_item">

            <div class="after_order_item_number">
              1
            </div>
            <div class="after_order_item_text">

              We contact you via discord immediately to get the order process started
            </div>
          </div>

          <div class="after_order_item">

            <div class="after_order_item_number">
              2
            </div>
            <div class="after_order_item_text">
              We assign you to the most suitable PRO Player in a very short timeframe
            </div>
          </div>

          <div class="after_order_item">

            <div class="after_order_item_number">
              3
            </div>
            <div class="after_order_item_text">
              We complete your order safely and ask you to write us a review. We send you a discount code for next time
              :)
            </div>
          </div>


        </div>


      </div>

    </div>
  </div>
</div>

<!--  <?php echo str_replace($_SERVER["DOCUMENT_ROOT"], '', __FILE__); ?> ] -->
