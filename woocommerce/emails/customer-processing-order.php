<?php
/**
 * Customer processing order email
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_email_header', $email_heading, $email );

$order_id = $order->get_order_number(); // Dynamically get the order ID

// Enhanced styling
$style = array(
    'button' => 'display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #0071a1; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif;',
    'button_wrapper' => 'text-align: center; margin: 20px 0;',
    'body' => 'font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; color: #515151; background-color: #f7f7f7; padding: 20px;',
);

?>

<div style="<?php echo esc_attr( $style['body'] ); ?>">
    <p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

    <p>This is a confirmation of your successfully placed order <?php echo esc_html( $order_id ); ?> on GladiatorBoost. We're preparing it now and will notify you when it's ready.</p>

    <div style="<?php echo esc_attr( $style['button_wrapper'] ); ?>">
        <a href="https://stagewq24.wxqw2.gladiatorboost.com/customer_chats/" style="<?php echo esc_attr( $style['button'] ); ?>">Go to Order Chat</a>
    </div>

    <h2>What's Next?</h2>
    <p>Stay tuned! We'll update you on your order's progress and notify you as soon as it's ready for action. Meanwhile, feel free to check back on our site for updates or explore more of what GladiatorBoost has to offer.</p>

    <div style="<?php echo esc_attr( $style['button_wrapper'] ); ?>">
        <a href="https://stagewq24.wxqw2.gladiatorboost.com/" style="<?php echo esc_attr( $style['button'] ); ?>">Visit GladiatorBoost Homepage</a>
    </div>
</div>

<?php

do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

if ( $additional_content ) {
    echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );