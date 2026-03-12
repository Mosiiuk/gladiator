<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// AJAX SEARCH GAMES
function search_games() {

	$search_value = $_POST['search'];

	$query_args = array(
		'post_type'      => 'product',
		'posts_per_page' => 4,
		'post_status'    => array( 'publish' ),
		'fields'         => array( 'ids', 'post_title' ),
		'cache_results'  => false,
		's'              => $search_value,
	);

	$query      = new WP_Query( $query_args );
	$totalCount = $query->found_posts;

	if ( $query->have_posts() ) {

		echo '<ul>';

		foreach ( $query->posts as $game ) {

			$descr   = get_field( 'description_text', $game->ID );
			$content = get_field( 'field_645a4a9ec6fef', 'header' );

			?>


      <li>
        <a href="<?php the_permalink( $game->ID ); ?>"><?php echo $game->post_title; ?></a>
        <p>
					<?php echo mb_strimwidth( $descr, 0, 150, '...' ); ?>
        </p>
      </li>

			<?php

		}

		echo '</ul>';

		if ( $totalCount > 4 ) {

			echo '<div class="result_bottom_wrap">
                    <div class="btn results_btn">
                        <a href="' . get_permalink( get_page_by_path( 'search' ) ) . '?search=' . $search_value . '">' . $content['search_view_all'] . '</a>
                    </div>
                    <div class="result_search_text">
                    <p>Looking for something in a different game?  <a href="#">Search all games instead</a></p>
                    </div>
                    </div>
                    ';
		}

	} else {

		?>

    <div class="result_item">
      <span class="not_found"><?php _e( 'No Games Found.' ); ?></span>
    </div>

		<?php
	}

	exit;
}

add_action( 'wp_ajax_search_games', 'search_games' );
add_action( 'wp_ajax_nopriv_search_games', 'search_games' );


// AJAX LOAD MORE PRODUCTS
function load_more_prod() {

	extract( $_POST );

	// $paged = ( ($offset+$per_page) / $per_page );

	$query_args = array(
		'post_status'    => [ 'publish' ],
		'post_type'      => 'product',
		'posts_per_page' => $per_page,
		'tax_query'      => [
			[
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $id
			]
		],
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'paged'          => $paged,

	);

	$query      = new WP_Query( $query_args );
	$totalCount = $query->found_posts;

	$posts = $query->get_posts();

	$html = '';
	if ( is_array( $posts ) && count( $posts ) ) {

		foreach ( $posts as $key => $item ) {
			$product_corner = get_field( 'product_corner', $item->ID );
			$product        = new WC_Product( $item->ID );

			set_query_var( 'post_item', $item );
			set_query_var( 'product', $product );
			set_query_var( 'tab_name', $game );
			set_query_var( 'product_corner', $product_corner );

			ob_start();
			get_template_part( 'tmpl/product_item', 'tmpl' );
			$html .= ob_get_contents();
			ob_end_clean();
		}
	}

	$config     = array( 'indent' => true, 'output-xhtml' => true, 'show-body-only' => 1 );
	$prettyhtml = tidy_parse_string( $html, $config, 'UTF8' );
	$prettyhtml->cleanRepair();

	if ( $totalCount < ( $offset + $per_page ) ) {
		$gotThemAll = true;
	} else {
		$gotThemAll = false;
	}

	$response = array( 'max_num_pages'=>$query->max_num_pages, 'html' => $prettyhtml, 'data' => $gotThemAll );
	echo json_encode( $response );


	exit;
}

add_action( 'wp_ajax_load_more_prod', 'load_more_prod' );
add_action( 'wp_ajax_nopriv_load_more_prod', 'load_more_prod' );


function set_coupon_code() {
	$msg  = '';
	$html = '';
	if ( class_exists( 'WooCommerce' ) ) {
		$woocommerce = WC();

		$raw_coupon_code = isset( $_POST['coupon_code'] ) ? $_POST['coupon_code'] : '';
		$coupon_code     = sanitize_text_field( $raw_coupon_code );

		$coupon = new WC_Coupon( $coupon_code );

		if ( $coupon->is_valid() ) {
			$woocommerce->cart->apply_coupon( $coupon_code );
			$woocommerce->cart->calculate_totals();
		} else {
			$msg = $coupon->get_error_message();
		}

		set_query_var( 'err_msg', $msg );
		ob_start();
		get_template_part( 'tmpl/cart/mini_cart' );
		$html .= ob_get_contents();
		ob_end_clean();
	}

	echo json_encode( [
		'POST' => $_POST,
		'msg'  => $msg,
		'html' => $html,
	] );
	wp_die();
}

add_action( 'wp_ajax_set_coupon_code', 'set_coupon_code' );
add_action( 'wp_ajax_nopriv_set_coupon_code', 'set_coupon_code' );


function cancel_coupon_code() {
	$msg  = '';
	$html = '';
	if ( class_exists( 'WooCommerce' ) ) {
		$woocommerce = WC();

		$raw_coupon_code = isset( $_POST['coupon_code'] ) ? $_POST['coupon_code'] : '';
		$coupon_code     = sanitize_text_field( $raw_coupon_code );

		$coupon = new WC_Coupon( $coupon_code );

		if ( $coupon->is_valid() ) {
			$woocommerce->cart->remove_coupon( $coupon_code );
			$woocommerce->cart->calculate_totals();
		} else {
			$msg = $coupon->get_error_message();
		}

		set_query_var( 'err_msg', $msg );
		ob_start();
		get_template_part( 'tmpl/cart/mini_cart' );
		$html .= ob_get_contents();
		ob_end_clean();
	}

	echo json_encode( [
		'POST' => $_POST,
		'msg'  => $msg,
		'html' => $html,
	] );
	wp_die();
}

add_action( 'wp_ajax_cancel_coupon_code', 'cancel_coupon_code' );
add_action( 'wp_ajax_nopriv_cancel_coupon_code', 'cancel_coupon_code' );


function remove_prod() {
	$msg  = '';
	$html = '';
	if ( class_exists( 'WooCommerce' ) ) {
		$woocommerce = WC();

		$cart_item_key = isset( $_POST['key'] ) ? $_POST['key'] : '';
		$cart_item_key = sanitize_text_field( $cart_item_key );

		$woocommerce->cart->remove_cart_item( $cart_item_key );
		$woocommerce->cart->calculate_totals();

		set_query_var( 'err_msg', $msg );
		ob_start();
		get_template_part( 'tmpl/cart/mini_cart' );
		$html .= ob_get_contents();
		ob_end_clean();
	}

	echo json_encode( [
		'POST' => $_POST,
		'msg'  => $msg,
		'html' => $html,
	] );
	wp_die();
}

add_action( 'wp_ajax_remove_prod', 'remove_prod' );
add_action( 'wp_ajax_nopriv_remove_prod', 'remove_prod' );


//----------------- 2025 ------------
add_action( 'wp_ajax_home_search_ext', 'home_search_ext' );
add_action( 'wp_ajax_nopriv_home_search_ext', 'home_search_ext' );

function home_search_ext()
{
    global $wpdb;

    $game_name = sanitize_text_field($_POST['game_name']);

    $sql = "SELECT p.ID, p.post_title 
        FROM wp_posts p
        LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'abreviations'
        WHERE p.post_type = 'product' 
        AND p.post_status = 'publish' 
        AND (
            p.post_title LIKE '%$game_name%' 
            OR p.post_excerpt LIKE '%$game_name%' 
            OR p.post_content LIKE '%$game_name%' 
            OR pm.meta_value LIKE '%$game_name%'
        )
        ORDER BY p.post_title DESC, p.post_date DESC 
        LIMIT 25;";

    $results = $wpdb->get_results($sql);

    $prod_html='<ul>';
    if (is_array($results) && count( $results))
    {
        foreach ($results as $key => $item)
        {
            $ln=get_permalink($item->ID);
            $prod_html.="<li><a href='$ln' >$item->post_title</a></li>";
        }
    }
    $prod_html.='</ul>';

    echo json_encode( [
        'POST' => $_POST,
        'html'  => $prod_html,
        '$results'  => $results,
    ] );
    wp_die();
}


//----------------- 2025 ------------