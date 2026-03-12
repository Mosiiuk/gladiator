<?php
/**
 * My Orders - Deprecated
 *
 * @deprecated 2.6.0 this template file is no longer used. My Account shortcode uses orders.php.
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

$my_orders_columns = apply_filters(
	'woocommerce_my_account_my_orders_columns',
	array(
		'order-number'  => esc_html__( 'Order', 'woocommerce' ),
		'order-date'    => esc_html__( 'Date', 'woocommerce' ),
		'order-total'   => esc_html__( 'Price', 'woocommerce' ),
        'order-status'  => esc_html__( 'Status', 'woocommerce' ),
       // 'order-actions' => '&nbsp;',
	)
);

$customer_orders = get_posts(
	apply_filters(
		'woocommerce_my_account_my_orders_query',
		array(
			'numberposts' => $order_count,
			'meta_key'    => '_customer_user',
			'meta_value'  => get_current_user_id(),
			'post_type'   => wc_get_order_types( 'view-orders' ),
			'post_status' => array_keys( wc_get_order_statuses() ),
		)
	)
);

?>
    <!-- [<?php echo __FILE__; ?> -->
<?php

if ( $customer_orders ) : ?>

	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<?php
                    $column_class=[
                        'order-date'    => 'woocommerce-orders-table__header-order-date',
                        'order-total'  => 'woocommerce-orders-table__header-order-price',
                        'order-status'   => 'woocommerce-orders-table__header-order-status',
                    ];

                    $status_tmpl=[
                        'completed'    => '<svg xmlns="http://www.w3.org/2000/svg" width="12px" height="12px" viewBox="0 0 12 12">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6 12A6 6 0 106 0a6 6 0 000 12zm2.576-7.02a.75.75 0 00-1.152-.96L5.45 6.389l-.92-.92A.75.75 0 003.47 6.53l1.5 1.5a.75.75 0 001.106-.05l2.5-3z" fill="#1ea51b"></path>
                      </svg>Completed',
                        'cancelled'  => '<svg width="20" height="20" viewBox="0 0 448 448">
                            <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(0,-604.36209)">
                          <path style="fill-opacity:1;stroke:none; fill:red" d="m 224,604.36209 a 224,223.99999 0 0 0 -224,224 224,223.99999 0 0 0 224,224.00001 224,223.99999 0 0 0 224,-224.00001 224,223.99999 0 0 0 -224,-224 z m -95.78943,84 L 224,784.15152 319.78943,688.36209 364,732.57266 268.21057,828.36209 364,924.15152 319.78943,968.36209 224,872.57266 128.21057,968.36209 84,924.15152 179.78943,828.36209 84,732.57266 128.21057,688.36209 Z" id="path3358" inkscape:connector-curvature="0"></path>
                        </g>
                      </svg>Cancelled',
                    ];

                    foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header <?php echo $column_class[$column_id].' '; echo esc_attr( $column_id ); ?>">
                        <span class="nobr"><?php echo esc_html( $column_name ); ?></span>
                    </th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php
			foreach ( $customer_orders as $customer_order ) :
				$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count();
				?>
				<tr class="order">
					<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
						<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
									<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</a>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>">
                                    <?php echo  $order->get_date_created()->date('d-m-Y'); ?>
                                </time>
							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php
                                    //echo esc_html( wc_get_order_status_name( $order->get_status() ) );
                                    if ( isset($status_tmpl[$order->get_status()]))
                                        echo $status_tmpl[$order->get_status()];
                                    else
                                        echo esc_html( wc_get_order_status_name( $order->get_status() ) );
                                ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								printf( _n( '%1$s', '%1$s', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
								<?php

								$actions = wc_get_account_orders_actions( $order );

								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
										echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
							<?php endif; ?>
						</td>

					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<!-- <?php echo __FILE__; ?> ]-->
