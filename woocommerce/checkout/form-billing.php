<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>

		<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

		<h4>Contact Information</h4>

		<div class="input__group">
			<input type="email" name="billing_email" required placeholder="Email" value="<?php echo $checkout->get_value( 'billing_email' ) ?>">
		</div>

        <!--
		<h4>Billing Address</h4>

		<div class="input__group double">
			<input type="text" name="billing_first_name" required placeholder="FIrst Name" value="<?php echo $checkout->get_value( 'billing_first_name' ) ?>">
			<input type="text" name="billing_last_name" required placeholder="Last Name" value="<?php echo $checkout->get_value( 'billing_last_name' ) ?>">
		</div>

		<div class="input__group">
			<input type="text" name="billing_address_1" required placeholder="Address" value="<?php echo $checkout->get_value( 'billing_address_1' ) ?>">
		</div>

		<div class="input__group">
			<input type="text" name="billing_city" required placeholder="City" value="<?php echo $checkout->get_value('billing_city' ) ?>">
		</div>



			  -->

<div class="input__group double">
        <input type="text" name="billing_first_name" required placeholder="FIrst Name" value="<?php echo $checkout->get_value( 'billing_first_name' ) ?>">
      <!--  <input type="text" name="billing_last_name" required placeholder="Last Name" value="<?php /*echo $checkout->get_value( 'billing_last_name' ) */?>">-->
    </div>

		<div class="input__group double">
			<?php
					$countries = WC()->countries->get_allowed_countries();

					if ( 1 === count( $countries ) ) {
						?><input type="hidden" name="billing_country" value="<?php current( array_keys( $countries ) )?>" class="country_to_state" readonly="readonly" /><?php ;
					} else{ ?>
						<select name="billing_country" required>
							<option disabled selected data-display="Country">Select a country</option>
							<?php
								$countries = WC()->countries->get_allowed_countries();

								foreach($countries as $ckey => $cvalue ){
									?>
										<option value="<?php echo esc_attr( $ckey ) ?>"><?php echo esc_html( $cvalue ) ?></option>
									<?php
								}
							?>
						</select>
					<?php }

					?>
						<!-- <input type="text" name="billing_postcode" required placeholder="Postal Code" value="<?php $checkout->get_value( 'billing_postcode' ) ?>">  -->
  </div>



<!-- <div class="input__group double">
    <?php
    $countries = WC()->countries->get_allowed_countries();

    if ( 1 === count( $countries ) ) {
        ?><input type="hidden" name="country" value="<?php current( array_keys( $countries ) )?>" class="country_to_state" readonly="readonly" /><?php ;
    } else{ ?>
        <select name="country" required>
            <option disabled selected data-display="Country">Select a country</option>
            <?php
            $countries = WC()->countries->get_allowed_countries();

            foreach($countries as $ckey => $cvalue ){
                ?>
                <option value="<?php echo esc_attr( $ckey ) ?>"><?php echo esc_html( $cvalue ) ?></option>
                <?php
            }
            ?>
        </select>
    <?php }

    ?>
</div> -->

	<div class="input__group agree">
            <input type="checkbox" name="billing_term_condit" id="billing_term_condit" required placeholder="Postal Code" value="1">
            <label for="billing_term_condit">- I agree to terms and conditions</label>
    </div>
      


	<?php /*do_action( 'woocommerce_after_checkout_billing_form', $checkout );*/ ?>


<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>
