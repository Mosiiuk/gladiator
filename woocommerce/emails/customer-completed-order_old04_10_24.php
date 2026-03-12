<?php
/**
 * Customer completed order email
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_email_header', $email_heading, $email );

// Enhanced styling
$style = array(
    'body' => 'font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; color: #515151; background-color: #f7f7f7; padding: 20px;',
    'button' => 'display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #0071a1; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif;',
    'button_wrapper' => 'text-align: center; margin: 20px 0;',
    'logo' => 'display: block; margin: 0 auto 20px; max-width: 100%; height: auto;',
);

?>

<div style="<?php echo esc_attr( $style['body'] ); ?>">
    <!-- Logo Image -->
    <img src="https://stagewq24.wxqw2.gladiatorboost.com/wp-content/uploads/2024/03/Logo1.png" alt="Logo" style="<?php echo esc_attr( $style['logo'] ); ?>">

    <p>Dear <?php echo esc_html( $order->get_billing_first_name() ); ?>,</p>

    <p>Your order with GladiatorBoost has been completed successfully! We hope you enjoyed our service.</p>

    <h2>How about an 8% discount on your next order?</h2>
    <p>It's simple. Just follow these steps:</p>
    <ol>
        <li>Visit our Trustpilot page at <a href="https://uk.trustpilot.com/review/stagewq24.wxqw2.gladiatorboost.com" target="_blank">https://uk.trustpilot.com/review/stagewq24.wxqw2.gladiatorboost.com</a> and leave us a review.</li>
        <li>Take a screenshot of your published review.</li>
        <li>Reply to this email with your screenshot attached.</li>
        <li>We'll send you an 8% discount code for your next purchase!</li>
    </ol>

    <p>This is a great opportunity to share your experience and save on your next order. Your feedback helps us improve and serve you better!</p>

    <div style="<?php echo esc_attr( $style['button_wrapper'] ); ?>">
        <a href="https://stagewq24.wxqw2.gladiatorboost.com" style="<?php echo esc_attr( $style['button'] ); ?>">Browse More Offers</a>
    </div>

    <p>Thank you for choosing GladiatorBoost. We look forward to serving you again!</p>
</div>

<?php

do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

if ( $additional_content ) {
    echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );