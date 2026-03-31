<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order container section__intro__mini order__successfull">
	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>
<!-- asd -->
		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="thx_logo_wrap">

			<style>
	svg .svg-elem-1{fill:transparent;-webkit-transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.5s;transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.5s}svg.active .svg-elem-1{fill:rgb(255,255,255)}svg .svg-elem-2{fill:transparent;-webkit-transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.6s;transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.6s}svg.active .svg-elem-2{fill:rgb(9,140,236)}svg .svg-elem-3{fill:transparent;-webkit-transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.7s;transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.7s}svg.active .svg-elem-3{fill:rgb(255,255,255)}svg .svg-elem-4{fill:transparent;-webkit-transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.8s;transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.8s}svg.active .svg-elem-4{fill:rgb(9,140,236)}svg .svg-elem-5{fill:transparent;-webkit-transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.9s;transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 0.9s}svg.active .svg-elem-5{fill:rgb(255,255,255)}svg .svg-elem-6{fill:transparent;-webkit-transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 1s;transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 1s}svg.active .svg-elem-6{fill:rgb(255,255,255)}svg .svg-elem-7{fill:transparent;-webkit-transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 1.1s;transition:fill 0.7s cubic-bezier(0.47,0,0.745,0.715) 1.1s}svg.active .svg-elem-7{fill:rgb(255,255,255)}
</style>
			<svg width="92" height="80" viewBox="0 0 92 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="order__successfull-logo">
				<g clip-path="url(#clip0_3108_1468)">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M88.5742 33.8551C85.6955 32.3795 81.4302 31.9873 81.4302 31.9873C81.4302 31.9873 83.6359 31.0575 86.1902 31.0575C88.3674 31.0575 90.9542 31.9873 90.9542 31.9873C90.9542 31.9873 89.4865 26.8974 87.143 22.1996C84.7225 17.3441 81.4302 12.8808 81.4302 12.8808L76.1918 15.6784L80.003 11.482C80.003 11.482 75.2512 6.71139 70.0047 4.02289C64.7785 1.34652 59.0535 0.760308 59.0535 0.760308L57.1479 10.0831L56.1951 0.760308L52.8623 9.6182L53.3367 0.29538C53.3367 0.29538 47.4172 -0.614262 41.9071 0.764351C36.3079 2.15914 30.4775 6.35562 30.4775 6.35562L32.3832 11.482L29.0504 7.28952C29.0504 7.28952 25.45 9.65459 22.8592 12.8848C20.2116 16.1798 18.5736 20.3439 18.5736 20.3439L23.812 23.6065L18.0992 21.7427C18.0992 21.7427 14.8556 31.6154 10.4808 37.5907C5.81413 43.9542 0 46.4405 0 46.4405C0 46.4405 8.86715 48.4296 16.1895 45.5066C21.3266 43.4609 25.7135 36.1838 25.7135 36.1838C25.7135 36.1838 29.2936 28.8056 34.2847 24.5323C38.7933 20.6714 44.7615 19.4019 44.7615 19.4019C44.7615 19.4019 43.7357 19.0502 41.4287 18.937C38.9798 18.8157 35.2375 19.4019 35.2375 19.4019C35.2375 19.4019 40.9259 16.7255 46.6671 16.6043C52.1082 16.4911 57.6182 18.9329 57.6182 18.9329C57.6182 18.9329 64.3284 21.6295 67.6166 25.923C71.4319 30.9038 71.9022 37.5786 71.9022 37.5786C71.9022 37.5786 77.023 36.1798 81.9005 35.7148C86.7862 35.2499 91.4245 35.7148 91.4245 35.7148C91.4245 35.7148 90.4879 34.8335 88.5661 33.8511L88.5742 33.8551Z" fill="#098CEC"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M70.045 42.713C70.045 42.713 66.7527 42.4502 64.3322 41.3142C61.34 39.9153 59.0938 37.5867 59.0938 37.5867C59.0938 37.5867 62.4104 39.2766 65.285 39.9153C67.588 40.4288 69.5706 39.9153 69.5706 39.9153C69.5706 39.9153 69.7085 32.1005 65.7594 27.3299C61.6157 22.3168 53.377 20.3398 53.377 20.3398C53.377 20.3398 56.3692 22.333 58.6154 24.5363C60.6426 26.5214 61.9482 28.7328 61.9482 28.7328C61.9482 28.7328 56.2557 23.5499 49.0914 22.2036C42.9489 21.0514 37.1875 24.5363 37.1875 24.5363C37.1875 24.5363 34.4182 26.1737 32.4275 29.6627C30.4449 33.1395 28.2919 38.4559 25.7619 41.7831C21.9831 46.7478 18.1436 48.3083 18.1436 48.3083C18.1436 48.3083 23.8198 50.4955 28.6203 53.9036C33.3438 57.2551 37.1915 61.8276 37.1915 61.8276L41.4771 41.7831V65.5551C41.4771 65.5551 46.0668 71.6962 50.0483 74.8779C55.0069 78.8359 59.5722 80.0043 59.5722 80.0043C59.5722 80.0043 58.5424 74.3968 59.0979 69.2826C59.7263 63.4852 61.9563 58.0961 61.9563 58.0961C61.9563 58.0961 57.4193 56.4466 55.2907 53.4346C53.1337 50.3863 53.3851 45.9756 53.3851 45.9756L64.8147 55.2984C64.8147 55.2984 63.1564 60.8856 63.3875 64.1563C63.6348 67.6372 65.7675 68.8177 65.7675 68.8177C65.7675 68.8177 66.2703 65.6198 67.1947 61.3586C67.9204 58.0273 69.0232 54.0087 69.5747 50.637C70.2964 46.2343 70.0531 42.713 70.0531 42.713H70.045Z" fill="white"/>
				</g>
				<defs>
				<clipPath id="clip0_3108_1468">
				<rect width="91.4286" height="80" fill="white"/>
				</clipPath>
				</defs>
			</svg>


			</div>

			<h2 class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received order__successfull-title-styles"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Order Successful!', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order order__successfull-title-styles">
					<?php esc_html_e( 'Your order number is ', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<!-- <li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li> -->

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<!-- <li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li> -->

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

           <!--NEW HTML CODE-->
		   <p class="order__successfull-text">Please follow the instructions below to contact us on Discord so we can start your order right away.</p>
           <button class="watch-btn" id="openVideo"  data-video="https://www.youtube.com/embed/nwM_dbpK8w4?autoplay=1">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g clip-path="url(#clip0_3108_1477)">
				<path d="M12 0C5.37267 0 0 5.37258 0 12C0 18.6274 5.37267 24 12 24C18.6273 24 24 18.6274 24 12C24 5.37258 18.6273 0 12 0ZM16.1475 12.6361L10.1475 16.3861C10.0261 16.4619 9.88805 16.5 9.75 16.5C9.62494 16.5 9.49969 16.4689 9.38634 16.4059C9.14794 16.2737 9 16.0228 9 15.75V8.25C9 7.97719 9.14794 7.72631 9.38634 7.59412C9.62475 7.46119 9.91627 7.46925 10.1475 7.61391L16.1475 11.3639C16.3667 11.5012 16.5 11.7415 16.5 12C16.5 12.2585 16.3667 12.4988 16.1475 12.6361Z" fill="#098CEC"/>
				</g>
				<defs>
				<clipPath id="clip0_3108_1477">
				<rect width="24" height="24" fill="white"/>
				</clipPath>
				</defs>
			</svg>

			 <span>Watch Video</span>
			</button>

			<h3 class="how-to-contacts__title">How to contact us</h3>

			<div class="contact__grid">
			
			<div class="contact__item">
				<div class="num">1</div>
				<div>
					<h3>Join Our Discord Gateway Server</h3>
					<p>Link: <a href="https://discord.com/invite/ZVa5Np3kR">discord.gg/ZVa5Np3kR</a></p>
					<p>This server ONLY allows us to appear in your DMs — nothing else.</p>
				</div>
			</div>

			<div class="contact__item">
				<div class="num">2</div>
				<div>
					<h3>Open Your Discord Search Bar</h3>
					<p>Go to: Find or Start a Conversation</p>
					<p>Type: <strong>gladiatorboost2024</strong></p>
			    </div>
			</div>

			<div class="contact__item">
				<div class="num">3</div>
				<div>
					<h3>Send Us a Direct Message</h3>
					<p>Click our profile → Send a DM with your order number</p>
					<p>This connects you directly to your assigned GladiatorBoost manager.</p>
			    </div>
			</div>

			</div>
		</div>

		<!-- Modal -->
		<div class="video-modal" id="videoModal">
			<div class="video-modal__content">
			<span class="close" id="closeVideo">&times;</span>
			<iframe id="videoFrame"
				src=""
				frameborder="0"
				allow="autoplay; encrypted-media"
				allowfullscreen>
			</iframe>
			</div>
		</div>

           <!--END NEW HTML CODE-->

            <div class="thankyou_text">
                <h2><?php echo get_field('thank_you_page_title','options'); ?></h2>
                <?php echo get_field('thank_you_page_text','options'); ?>
            </div>
												
            <!-- REDIRECT TO CHAT -->
            <?php
                $current_user = wp_get_current_user();
                $link = '';
                if (in_array('subscriber', $current_user->roles) || in_array('customer', $current_user->roles) )
                {
                    $gladiator_dashboard_plugin = new Gladiator_Dashboard_Plugin();
                    $link = get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_chats]'));
                }
            ?>
            <script>
                /*setInterval(function(){
                    let data = {
                        action: 'gladiator_redirect_to_chat',
                        order_number: <?php echo $order->get_order_number();?>,
                    };

                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl.url,
                        data: data,
                        success: function (data) {
                            let obj = jQuery.parseJSON(data);

                            if (parseInt(obj.chat_id)>0 )
                            {
                               window.location.href = '<?php echo $link;?>?chat_id='+obj.chat_id;
                            }
                            console.log(obj.chat_id)
                        }
                    });
                },1500);*/
            </script>
            <!-- /REDIRECT TO CHAT -->


		<?php endif; ?>

		<!-- <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?> -->
		<!-- <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>  -->

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php /*echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */?></p>

	<?php endif; ?>

</div>
