<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 6.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>

<p><?php printf( esc_html__( 'Welcome to %1$s! Your journey to an enhanced gaming experience begins now. Your username is %2$s. Discover your account area to view orders, manage your password, and explore a wide range of offers at: %3$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?></p>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated && $set_password_url ) : ?>
	<p><a href="<?php echo esc_attr( $set_password_url ); ?>" class="woocommerce-button button"><?php esc_html_e( 'Set Your New Password', 'woocommerce' ); ?></a></p>
<?php endif; ?>

<!-- Custom CTA Button -->
<p style="text-align:center; margin-top: 20px;">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="woocommerce-button button alt" style="background-color: #345C7D; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;"><?php esc_html_e( 'Browse Offers on GladiatorBoost', 'woocommerce' ); ?></a>
</p>

<?php if ( $additional_content ) : ?>
	<?php echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) ); ?>
<?php endif; ?>

<?php do_action( 'woocommerce_email_footer', $email ); ?>