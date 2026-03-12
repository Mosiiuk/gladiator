<?php
/**
 * WooCommerce Order Confirmation Email Template for GladiatorBoost
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - GladiatorBoost</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
        }
        .order-details {
            margin-bottom: 20px;
        }
        .order-details th, .order-details td {
            text-align: left;
            padding: 10px;
        }
        .order-details th {
            background-color: #f7f7f7;
        }
        .order-details td {
            border-bottom: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .review-box {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #27ae60;
            border-radius: 5px;
            font-style: italic;
        }
        .discord-instructions {
            margin-top: 30px;
            padding: 15px;
            background-color: #f7f7f7;
            border-radius: 8px;
        }
        .discord-instructions h2 {
            color: #3498db;
            font-size: 18px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Thank You for Your Order, <?php echo esc_html( $order->get_billing_first_name() ); ?>!</h1>
    <p>Your order <strong>#<?php echo $order->get_order_number(); ?></strong> has been received and is now being processed. Below are the details of your purchase:</p>

    <table class="order-details">
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product();
            ?>
            <tr>
                <td><?php echo esc_html( $item->get_name() ); ?></td>
                <td><?php echo esc_html( $item->get_quantity() ); ?></td>
                <td><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Total</th>
            <td></td>
            <td><strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong></td>
        </tr>
        </tfoot>
    </table>

    <a href="<?php echo esc_url( home_url() ); ?>" class="button">Back to GladiatorBoost</a>

    <div class="discord-instructions">
        <h2>Connect with Us on Discord</h2>
        <p>To ensure a smooth order process, please follow these instructions to reach us on Discord:</p>
        <ol>
            <li><strong>Join our server:</strong> <a href="https://discord.gg/ZVa5Npz3kR">https://discord.gg/ZVa5Npz3kR</a>. (Note: It's empty on purpose, no error!)</li>
            <li><strong>Search for "gladiatorboost2024" in Discord's search bar:</strong> Use the "Find and start conversations" feature, not the server search bar. If needed, try with "@gladiatorboost2024" to locate us.</li>
            <li><strong>Send us a DM with your order number:</strong> Our response time may vary from 1-3 hours due to high order volumes. We appreciate your patience and assure you that we’re working through messages fairly and efficiently.</li>
        </ol>
        <p><strong>Note:</strong> Sending multiple messages may push your request to the top of our DM list. To keep the process smooth, please avoid sending multiple messages, and we’ll get to you as soon as possible.</p>
    </div>

    <div class="review-box">
        After successful order completion, remember to write us a review of our service to receive a bonus discount for any future orders!
    </div>

    <div class="footer">
        &copy; <?php echo date('Y'); ?> GladiatorBoost. All rights reserved. | <a href="<?php echo esc_url( home_url() ); ?>">Visit our website</a>
    </div>
</div>
</body>
</html>
