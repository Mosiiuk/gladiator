<?php
if ( ! defined( 'ABSPATH' ) ){
    exit;
}


function admin_default_page() {
    return wc_get_account_endpoint_url( 'edit-account' );
}
add_filter('login_redirect', 'admin_default_page');

add_shortcode( 'product_category_menu', 'product_category_menu_func' );

function product_category_menu_func( $atts ){
    $content = "<ul>";

    $categories = get_terms(['taxonomy' => 'product_cat']);

    foreach($categories as $category){
        $content .= "<li class='dropdown'>";

        $content .= "<a href='".get_term_link($category->term_id)."'>$category->name</a>";

        $content .= "<ul class='list'>";

        $args = array(
            'post_status' => 'publish',
            'post_type' => 'product',
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category->slug
                ]
            ]
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ){ $query->the_post();
                $content .= "<li><a href='".get_permalink()."'>".get_the_title()."</a></li>";
            }
        }
        wp_reset_postdata();

        $content .= "</ul></li>";
    }

    $content .= "</ul>";
    return $content;
}

// Menu from categories

function get_menu_from_cat($categories){

    if( is_array($categories)){

        $content = "<ul>";

        foreach($categories as $category){
            $args = array(
                'post_status' => ['publish'],
                'post_type' => 'product',
                'posts_per_page'=>-1,
                'tax_query' => [
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $category->slug
                    ]
                ]
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                $content .= "<li class='dropdown'>";

                $content .= "<a href='".get_term_link($category->term_id)."'>$category->name</a>";

                $content .= "<ul class='list'>";
                while ( $query->have_posts() ){ $query->the_post();
                    $content .= "<li><a href='".get_permalink()."'>".get_the_title()."</a></li>";
                }
                $content .= "</ul></li>";
            }
            wp_reset_postdata();
        }

        $content .= "</ul>";

        echo $content;
    }
}

function gladiator_get_product_category_terms($product_id) {
    $terms = get_the_terms($product_id, 'product_cat');

    if (is_wp_error($terms) || !is_array($terms)) {
        return [];
    }

    return array_values(array_filter($terms, static function ($term) {
        return $term instanceof WP_Term && (int) $term->term_id !== 15;
    }));
}

function gladiator_get_product_primary_category($product_id) {
    $terms = gladiator_get_product_category_terms($product_id);

    if (!$terms) {
        return null;
    }

    usort($terms, static function ($left, $right) {
        $left_depth = count(get_ancestors($left->term_id, 'product_cat', 'taxonomy'));
        $right_depth = count(get_ancestors($right->term_id, 'product_cat', 'taxonomy'));

        if ($left_depth === $right_depth) {
            return $left->term_id <=> $right->term_id;
        }

        return $right_depth <=> $left_depth;
    });

    return $terms[0];
}

function gladiator_get_product_main_category($product_id) {
    $primary_category = gladiator_get_product_primary_category($product_id);

    if (!$primary_category instanceof WP_Term) {
        return null;
    }

    $ancestors = get_ancestors($primary_category->term_id, 'product_cat', 'taxonomy');

    if (!$ancestors) {
        return $primary_category;
    }

    $main_category_id = end($ancestors);
    $main_category = get_term($main_category_id, 'product_cat');

    return $main_category instanceof WP_Term ? $main_category : $primary_category;
}

function gladiator_get_product_category_chain($product_id) {
    $primary_category = gladiator_get_product_primary_category($product_id);

    if (!$primary_category instanceof WP_Term) {
        return [];
    }

    $chain = [];
    $ancestor_ids = array_reverse(get_ancestors($primary_category->term_id, 'product_cat', 'taxonomy'));

    foreach ($ancestor_ids as $ancestor_id) {
        $ancestor = get_term($ancestor_id, 'product_cat');

        if ($ancestor instanceof WP_Term && (int) $ancestor->term_id !== 15) {
            $chain[] = $ancestor;
        }
    }

    $chain[] = $primary_category;

    return $chain;
}

function gladiator_render_product_breadcrumb($product_id = 0) {
    $product_id = $product_id ?: get_the_ID();

    if (!$product_id) {
        return;
    }

    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';

    foreach (gladiator_get_product_category_chain($product_id) as $category) {
        echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
    }

    echo '<li>' . esc_html(get_the_title($product_id)) . '</li>';
}


// The Image

function get_the_image($image, $object = false){
    if(!is_array($image)){
        if($object !== false){
            $image = get_field($image, $object);
        } else {
            $image = get_field($image);
        }
    }
    if($image and is_array($image)){
        return '<img src="' . $image['url'] . '" alt="' .(($image['alt'] != "") ? $image['alt'] : 'alt'). '">';
    }
}

function the_image($image, $object = false){
    echo get_the_image($image, $object);
}

// The background image

function get_image_url($image, $object = false){
    if(!is_array($image)){
        if($object !== false){
            $image = get_field($image, $object);
        } else {
            $image = get_field($image);
        }
    }

    if($image and is_array($image)){
        return $image['url'];
    }
}

function the_image_url($image, $object = false){
    echo get_image_url($image, $object);
}

// Header currency

function header_currency( $select_class = 'js-currency_select' ){
    global $WOOCS;

    if(is_object($WOOCS) and isset($WOOCS->current_currency))
    {
        $current_currency = $WOOCS->current_currency;
        $currencies=$WOOCS->get_currencies();
        if(!count( $currencies)) return;
        $content = "";
        $select_class = trim( $select_class );

        $content='<!-- <div class="mobile_currency"></div>--><select class="' . esc_attr( $select_class ) . '" >';
        foreach ($currencies as  $key=> $currencie) {
            $content.="<option data-symbol='$currencie[symbol]' value='$key' " . (($key == $current_currency) ? 'selected' : '') .
                ">{$currencie['name']}</option>";
        }
        $content.='</select>';


        echo $content;
    }


}

// benefits shortcode

add_shortcode( 'benefits', 'benefits_func' );

function benefits_func($atts){
    $conternt = '';
    $id = (int)$atts['id'] - 1;
    $shortcodes = get_field('benefits_shortcodes', 'shortcode');
    if(isset($shortcodes[$id])){
        $shortcode = $shortcodes[$id];
    } else if(isset($shortcodes[0])){
        $shortcode = $shortcodes[0];
    }else {
        return;
    }

    $shortcode;

    $conternt .= "<div class='row'>";

    foreach($shortcode['benefits'] as $box){
        $conternt .= "<div class='col-lg-4'>
            <div class='advantage__item'>
                <div class='advantage__icon'>".get_the_image($box['image'])."</div>
                <h3>{$box['title']}</h3>
                <p>
                    {$box['description']}
                </p>
            </div>
        </div>";
    }

    $conternt .= "</div>";
    return $conternt;
}

// How to order shortcode

add_shortcode( 'how_to_order', 'how_to_order_func' );

function how_to_order_func($atts){
    $conternt = '';
    $id = (int)$atts['id'] - 1;
    $shortcodes = get_field('how_to_order', 'shortcode');
    if(isset($shortcodes[$id])){
        $shortcode = $shortcodes[$id];
    } else if(isset($shortcodes[0])){
        $shortcode = $shortcodes[0];
    }else {
        return;
    }

    $shortcode;

    $bg = get_image_url($shortcode['backgroubd']);

//    if($bg) {
//        $conternt .= "<div class='background__img' data-parallax='scroll' data-image-src='$bg'></div>";
//    }

    $conternt .= "<div class='container'><div class='row'><div class='col-lg-12'>";

    $conternt .= "<h2>{$shortcode['title']}</h2>";

    $conternt .= "<ul class='howtoorder__list'>";

    foreach($shortcode['steps'] as $box){
        $conternt .= "        
        <li>
            <div class='dots__way'></div>
            <div class='howtoorder__img'>".get_the_image($box['image'])."</div>
            <h4>{$box['title']}</h4>
            <p>
                {$box['description']}
            </p>
        </li>";
    }

    $conternt .= "</ul></div></div></div>";
    return $conternt;
}

//------------------------------------------------------------------

add_action( 'wp', 'save_wc_additional_details' );
function save_wc_additional_details()
{
    $user_id = get_current_user_id();


    if ( isset($_POST['account_discort_tag']) && $_POST['account_discort_tag']=="" )
    {
        wc_add_notice( __( 'Discord ID is empty.', 'woocommerce' ), 'error' );
    }

    if (isset($_POST['account_discort_tag']) && $_POST['account_discort_tag']!="" )
        update_user_meta( $user_id, 'account_discort_tag', sanitize_text_field(  $_POST['account_discort_tag'] ) );



    if (isset($_POST['account_tel']))
        update_user_meta( $user_id, 'account_tel', sanitize_text_field(  $_POST['account_tel'] ) );


    if (isset($_POST['account_tel']))
        update_user_meta( $user_id, 'account_tel', sanitize_text_field(  $_POST['account_tel'] ) );
}


function action_woocommerce_customer_save_address( $user_id, $load_address ) {
    if ( !is_admin()) {
        wp_safe_redirect(wc_get_account_endpoint_url('edit-account'));
        exit;
    }
};
add_action( 'woocommerce_customer_save_address', 'action_woocommerce_customer_save_address', 1110, 2 );

$action='get_product_home';
add_action("wp_ajax_nopriv_$action", "$action");
add_action("wp_ajax_$action","$action" );
function get_product_home()
{
    $terms_slugs = $_POST['term_slug'];
    $tab_name = $_POST['term_slug']['tab_name'];
    $fron_page_id = get_option('page_on_front');

    $best_deals = get_field('special_offers',$fron_page_id);
    $html='';
    if (is_array($best_deals) && count($best_deals))
    {

        foreach ($best_deals as $key => $item)
        {
            $ID = $item['product'];
            $term_list = wp_get_post_terms($ID, 'product_cat', array( 'fields' => 'all' ) );
            $product = new WC_Product($ID);

            $find_cat=false;
            foreach ($term_list as $item_term)
            {
                if ( in_array($item_term->slug,$terms_slugs['slug']) )
                {
                    $find_cat = true;
                    break;
                }
            }

            if ($find_cat == false && count($terms_slugs['slug'])==1 ) continue;

            set_query_var('product',$product);
            set_query_var('tab_name',$tab_name);
            set_query_var('term_list',$term_list);

            ob_start();
            get_template_part('tmpl/product_item', 'tmpl');
            $html.= ob_get_contents();
            ob_end_clean();
        }
    }

    /*$args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                 'field' => 'slug',
                'terms' => $terms_slugs['slug']
            ]
        ]
    ];


    $query = new WP_Query( $args );
    $posts = $query->get_posts();

    $html='';
    if (is_array($posts) && count($posts))
    {
        foreach ($posts as $key => $item)
        {
            $product = new WC_Product($item->ID);
            set_query_var('post_item',$item);
            set_query_var('product',$product);
            set_query_var('tab_name',$tab_name);

            ob_start();
            get_template_part('tmpl/product_item', 'tmpl');
            $html.= ob_get_contents();
            ob_end_clean();
        }
    }*/

    echo json_encode([
        '$_POST'=>$_POST,
        'args'=>$args,
        '$query'=>$query,
        'posts'=>$posts,
        'html'=>$html,
    ]);
    wp_die();
}


$action='custom_register_recaptcha';
add_action("wp_ajax_nopriv_$action", "$action");
add_action("wp_ajax_$action","$action" );

function gladiator_verify_signup_recaptcha( $recaptcha_response ) {
    $enable_on_sign_ups = get_field( 'enable_on_sign_ups', 'option' );
    $recaptcha_secret   = (string) get_field( 'google_recaptcha_v2_secret', 'option' );

    if ( ! $enable_on_sign_ups ) {
        return array(
            'success'     => true,
            'valid'       => 1,
            'error'       => '',
            'error_codes' => array(),
        );
    }

    if ( $recaptcha_secret === '' || $recaptcha_response === '' ) {
        return array(
            'success'     => false,
            'valid'       => 0,
            'error'       => 'Recaptcha error',
            'error_codes' => array( 'missing-input' ),
        );
    }

    $request_args = array(
        'timeout' => 15,
        'body'    => array(
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
        ),
    );

    $response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', $request_args );

    if ( is_wp_error( $response ) ) {
        error_log( 'Recaptcha verification request failed: ' . $response->get_error_message() );

        return array(
            'success'     => false,
            'valid'       => 0,
            'error'       => 'Recaptcha verification failed',
            'error_codes' => array( 'request-failed' ),
        );
    }

    $body          = wp_remote_retrieve_body( $response );
    $response_keys = json_decode( $body, true );

    if ( ! is_array( $response_keys ) ) {
        error_log( 'Recaptcha verification returned invalid JSON: ' . $body );

        return array(
            'success'     => false,
            'valid'       => 0,
            'error'       => 'Recaptcha verification failed',
            'error_codes' => array( 'invalid-json' ),
        );
    }

    $success     = ! empty( $response_keys['success'] );
    $error_codes = array();

    if ( ! empty( $response_keys['error-codes'] ) && is_array( $response_keys['error-codes'] ) ) {
        $error_codes = array_map( 'sanitize_text_field', $response_keys['error-codes'] );
    }

    if ( ! $success ) {
        error_log( 'Recaptcha verification failed: ' . wp_json_encode( $response_keys ) );
    }

    return array(
        'success'     => $success,
        'valid'       => $success ? 1 : 0,
        'error'       => $success ? '' : 'Recaptcha error',
        'error_codes' => $error_codes,
    );
}

function custom_register_recaptcha()
{
    $recaptcha_response = isset( $_POST['recaptcha_response'] ) ? sanitize_text_field( wp_unslash( $_POST['recaptcha_response'] ) ) : '';
    $verification       = gladiator_verify_signup_recaptcha( $recaptcha_response );


    echo json_encode([
        '$_POST'=>$_POST,
        'valid'=>$verification['valid'],
        'error'=>$verification['error'],
        'error_codes'=>$verification['error_codes'],
    ]);
    wp_die();
}


$action='custom_register';
add_action("wp_ajax_nopriv_$action", "$action");
add_action("wp_ajax_$action","$action" );

function custom_register()
{
    $user_email = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
    $user_login = isset( $_POST['user_login'] ) ? sanitize_user( wp_unslash( $_POST['user_login'] ) ) : '';
    $user_pass = isset( $_POST['user_pass'] ) ? (string) wp_unslash( $_POST['user_pass'] ) : '';
    $recaptcha_response = isset( $_POST['recaptcha_response'] ) ? sanitize_text_field( wp_unslash( $_POST['recaptcha_response'] ) ) : '';
    $redirect_url = isset( $_POST['redirect_url'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_url'] ) ) : home_url( '/' );

    $enable_on_sign_ups = get_field('enable_on_sign_ups','option');

    if ($enable_on_sign_ups && !$recaptcha_response)
    {
        $reg=false;
        $error='Recaptcha error';
        echo json_encode([
            '$_POST'=>$_POST,
            'error'=>$error,
            'error_codes'=>array( 'missing-input' ),
            'reg'=>$reg,
        ]);
        wp_die();
        exit;
    }


    $email_exists = email_exists($user_email);
    $username_exists = username_exists($user_login);
    $error='';
    $reg=false;
    $logged_in = false;
    $recaptcha_error_codes = array();

    if ( $enable_on_sign_ups && $recaptcha_response ) {
        $verification = gladiator_verify_signup_recaptcha( $recaptcha_response );

        if ( ! $verification['success'] ) {
            $error = $verification['error'];
            $recaptcha_error_codes = $verification['error_codes'];
        }
    }

    if ( !$email_exists && !$username_exists )
    {
        if ( $error === '' ) {
            $result = wp_create_user($user_login, $user_pass, $user_email);
        } else {
            $result = new WP_Error( 'recaptcha_error', $error );
        }

        if (is_wp_error($result))
        {
            $error = $result->get_error_message();
        }
        else
        {
            $user = get_user_by('id', $result);
            $reg=true;

            $signon = wp_signon(
                array(
                    'user_login'    => $user_login,
                    'user_password' => $user_pass,
                    'remember'      => true,
                ),
                is_ssl()
            );

            if ( is_wp_error( $signon ) ) {
                $error = $signon->get_error_message();
            } else {
                wp_set_current_user( $signon->ID );
                $logged_in = true;
            }
        }
    }

    echo json_encode([
        '$_POST'=>$_POST,
        'email_exists'=>$email_exists,
        'username_exists'=>$username_exists,
        'error'=>$error,
        'error_codes'=>$recaptcha_error_codes,
        'reg'=>$reg,
        'logged_in'=>$logged_in,
        'redirect_url'=>$redirect_url,
    ]);
    wp_die();
}


$action='custom_login';
add_action("wp_ajax_nopriv_$action", "$action");
add_action("wp_ajax_$action","$action" );

function custom_login()
{
    $user_login = isset( $_POST['user_login'] ) ? sanitize_text_field( wp_unslash( $_POST['user_login'] ) ) : '';
    $user_pass = isset( $_POST['user_pass'] ) ? (string) wp_unslash( $_POST['user_pass'] ) : '';
    $redirect_url = isset( $_POST['redirect_url'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_url'] ) ) : home_url( '/' );

    if ( '' === $user_login || '' === $user_pass ) {
        echo wp_json_encode(
            array(
                'logged_in'    => false,
                'error'        => __( 'Please fill in both login and password.', 'gladiator' ),
                'redirect_url' => $redirect_url,
            )
        );
        wp_die();
    }

    $signon = wp_signon(
        array(
            'user_login'    => $user_login,
            'user_password' => $user_pass,
            'remember'      => true,
        ),
        is_ssl()
    );

    if ( is_wp_error( $signon ) ) {
        echo wp_json_encode(
            array(
                'logged_in'    => false,
                'error'        => $signon->get_error_message(),
                'redirect_url' => $redirect_url,
            )
        );
        wp_die();
    }

    wp_set_current_user( $signon->ID );

    echo wp_json_encode(
        array(
            'logged_in'    => true,
            'error'        => '',
            'redirect_url' => $redirect_url,
        )
    );
    wp_die();
}


add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields' );
function wc_save_account_details_required_fields( $required_fields ){
    unset( $required_fields['account_display_name'] );
    unset( $required_fields['account_last_name'] );
    $required_fields["account_discort_tag"]=__( 'Discord ID', 'woocommerce' );
    return $required_fields;
}


function modify_search_query($query_vars) {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $query_vars['s'] = sanitize_text_field($_GET['search']);
    }
    return $query_vars;
}
add_filter('request', 'modify_search_query');
